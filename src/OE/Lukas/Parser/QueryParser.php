<?php
/**
 * @package   OE.Lukas
 * @copyright 2012 {@link http://www.vioe.be Vlaams Instituut voor het Onroerend Erfgoed}
 * @author    Dieter Standaert <dieter.standaert@gmail.com>
 * @license   http://opensource.org/licenses/mit-license.php The MIT License
 */

namespace OE\Lukas\Parser;

use OE\Lukas\Parser\QueryScanner;

use OE\Lukas\QueryTree\Text;
use OE\Lukas\QueryTree\Word;
use OE\Lukas\QueryTree\ExplicitTerm;
use OE\Lukas\QueryTree\Negation;
use OE\Lukas\QueryTree\DisjunctiveExpressionList;
use OE\Lukas\QueryTree\ConjunctiveExpressionList;
use OE\Lukas\QueryTree\SubExpression;

/**
 * QueryParser
 *
 *  A parser using the QueryScanner as input for tokens. The parser builds a
 *  a query tree, representing the query expression delivered as input.
 *  The parser returns a Query Tree if the parsing is successful or null if it failed.
 *  The parser will try to parse the entire input string and delivers feedback on errors, 
 *  for each expression it could not parse.
 *
 * @package   OE.Lukas
 * @since     0.1.0
 * @copyright 2012 {@link http://www.vioe.be Vlaams Instituut voor het Onroerend Erfgoed}
 * @author    Dieter Standaert <dieter.standaert@gmail.com>
 * @license   http://opensource.org/licenses/mit-license.php The MIT License
 */
class QueryParser
{
    /**
     * scanner
     * @var QueryScanner $scanner
     */
    protected $scanner;

    /**
     * feedback
     *  An array containing strings with an error message for every expression
     *  that could not be parsed.
     * @var array $feedback
     */
    protected $feedback;

    /**
     * __construct
     *
     */
    public function __construct()
    {
        $this->scanner = new QueryScanner();
        $this->feedback = array();
    }

    /**
     * readString
     *  resets the input string and feedback.
     * @param string $input
     * @return void
     */
    public function readString($input)
    {
        $this->scanner->readString($input);
        $this->feedback = array();
    }

    /**
     * addFeedback
     *  private function to add an error message to the feedback array.
     * @param string $input
     * @return void
     */
    protected function addFeedback($message)
    {
        $this->feedback[] = $message;
    }

    /**
     * hasFeedback
     *  Checks if the parser has any feedback to deliver.
     * @return boolean
     */
    public function hasFeedback()
    {
        return count($this->feedback) > 0;
    }

    /**
     * getFeedback
     *  Returns an array with feedback (error) messages from the parser.
     * @return boolean
     */
    public function getFeedback()
    {
        return $this->feedback;
    }

    /**
     * readTerm
     *  Makes the parser read a single term. This can be a 
     *  word, text, or explicit term.
     * @param integer $tokenType
     * @param string $word
     * @return OE\Lukas\QueryTree\SingleTerm or false if failed.
     */
    protected function readTerm($tokenType, $word)
    {
        if($tokenType != QueryScanner::COLON) {
            return $word;
        }
        $value = null;
        switch($this->scanner->next()) {
            case QueryScanner::TEXT :
                $value =  new Text($this->scanner->getToken());
                break;
            case QueryScanner::WORD : 
                $value =  new Word($this->scanner->getToken());
                break;
            default:
                $this->addFeedback("Error. Expected Word or Text. Found: " . $this->scanner->getTokenTypeText());
                return false;

        }
        $this->scanner->next();
        return new ExplicitTerm($word, $value);
    }

    /**
     * readExpression
     *  Makes the parser read an expression. This can be:
     *  * '(' Subexpression ')'
     *  * '"' text '"'
     *  * Word
     *  * Word:Text
     *  * Word:Word
     * @param integer $tokenType
     * @return QueryItem or false if failed.
     */
    protected function readExpression($tokenType)
    {
        switch($tokenType) {
            case QueryScanner::LPAREN :
                return $this->readSubQuery($tokenType);
            case QueryScanner::TEXT :
                $text = new Text($this->scanner->getToken());
                $this->scanner->next();
                return $text;
            case QueryScanner::WORD :
                $word =  new Word($this->scanner->getToken());
                return $this->readTerm($this->scanner->next(), $word);
            case QueryScanner::ILL:
                $this->addFeedback("Error. Expected Expression. Found illegal character: " . $this->scanner->getTokenTypeText());
            case QueryScanner::QUOTE:
                $this->addFeedback("Error. Opening quote at pos "
                    . $this->scanner->getPosition()
                    . " lacks closing quote: '"
                    . $this->scanner->getToken()
                    . "'");
            case QueryScanner::OROP:
                $this->addFeedback("Error. Expected Expression. OR operator found at pos "
                    . $this->scanner->getPosition()
                    . "' "
                    . $this->scanner->getToken()
                    . "' remaining: '"
                    . $this->scanner->getRemainingData()
                    . "'");
            case QueryScanner::RPAREN : 
            case QueryScanner::EOL :
            default:
                return false;
        }
    }

    /**
     * readNegation
     *  Makes the parser read a negation. This can be:
     *  * Expression
     *  * '-' Expression
     * @param integer $tokenType
     * @return OEPSutil_QueryItem or false if failed.
     */
    protected function readNegation($tokenType)
    {
        if($tokenType != QueryScanner::MINUS) 
        {
            return $this->readExpression($tokenType);
        } else {
            $expression = $this->readExpression($this->scanner->next());
            if($expression) {
                return new Negation($expression);
            } else {
                $this->addFeedback("Error. MINUS not followed by a valid expression.");   
                return false;
            }

        }
    }
    /**
     * readOrExpressionList
     *  Makes the parser read a list of OR statements. This can be:
     *  * Expression
     *  * Expression OR Expression OR ...
     * @param integer $tokenType
     * @return OEPSutil_QueryItem or false if failed.
     */
    protected function readOrExpressionList($tokenType)
    {
        $expressions = array();
        $lastExpression = false;
        do
        {
            $lastExpression =  $this->readNegation($this->scanner->getTokenType());
            $expressions[] = $lastExpression;
        }
        while (($lastExpression) 
            && ($this->scanner->getTokenType() == QueryScanner::OROP)
            && ($this->scanner->next()));

        if($lastExpression)
        {
            if(sizeof($expressions) == 1) {
                return $expressions[0];
            } else {
                return new DisjunctiveExpressionList($expressions);
            }

        } else {
            return false; 
        }
    }

    /**
     * readAndExpressionList
     *  Makes the parser read a list of statements. This can be:
     *  * Expression
     *  * Expression Expression ...
     * @param integer $tokenType
     * @return OEPSutil_QueryItem or false if failed.
     */
    protected function readAndExpressionList($tokenType)
    {
        $expressions = array();
        $lastExpression =  $this->readOrExpressionList($this->scanner->getTokenType());
        while ($lastExpression) 
        {
            $expressions[] = $lastExpression;
            $lastExpression =  $this->readOrExpressionList($this->scanner->getTokenType());
        }

        switch($this->scanner->getTokenType()) {
            case QueryScanner::RPAREN : 
            case QueryScanner::EOL : 
                if(sizeof($expressions) == 1) {
                    return $expressions[0];
                } else {
                    return new ConjunctiveExpressionList($expressions);
                }
            default:
                $this->addFeedback("Error. Expected Expression. Found: " . $this->scanner->getTokenTypeText());
                return false;
        }
    }


    /**
     * readSubQuery
     *  Makes the parser read paren closed (sub)query. The passed token
     *  should be the left paren.
     * @param integer $tokenType
     * @return OEPSutil_QueryItem or false if failed.
     */
    protected function readSubQuery($tokenType)
    {   
        $expressionlist = $this->readAndExpressionList($this->scanner->next());
        if($this->scanner->getTokenType() == QueryScanner::RPAREN)
        {
            $this->scanner->next();
            return new SubExpression($expressionlist);
        } else {
            $this->addFeedback("Error. Expected Right Paren.");
            return false;
        }
    }

    /**
     * parse
     *  Makes the parser build an expression tree from the given input.
     * @return OEPSutil_QueryItem or false if failed.
     */
    public function parse()
    {
        return $this->readAndExpressionList($this->scanner->next() );
    }

}
