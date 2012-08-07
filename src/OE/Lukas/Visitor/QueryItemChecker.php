<?php
/**
 * @package     OE.Lukas
 * @copyright   2012 {@link http://www.vioe.be Vlaams Instituut voor het Onroerend Erfgoed}
 * @author      Dieter Standaert <dieter.standaert@gmail.com> 
 * @license   http://opensource.org/licenses/mit-license.php The MIT License
 */

namespace OE\Lukas\Visitor;

use OE\Lukas\QueryTree\Item;
use OE\Lukas\QueryTree\Word;
use OE\Lukas\QueryTree\Text;
use OE\Lukas\QueryTree\ExplicitTerm;
use OE\Lukas\QueryTree\SubExpression;
use OE\Lukas\QueryTree\Negation;
use OE\Lukas\QueryTree\DisjunctiveExpressionList;
use OE\Lukas\QueryTree\ConjunctiveExpressionList;

/**
 * QueryItemChecker
 *
 * @package     OEPS.util
 * @since       0.1.0
 * @copyright   2012 {@link http://www.vioe.be Vlaams Instituut voor het Onroerend Erfgoed}
 * @author      Dieter Standaert <dieter.standaert@gmail.com> 
 * @license   http://opensource.org/licenses/mit-license.php The MIT License
 */
class QueryItemChecker implements IQueryItemVisitor
{
    /**
     * @var string label
     */
    private $label;

    /**
     * @var TrefwoordChecker checker
     */
    private $checker;

    /**
     * @var QueryContext context
     */
    private $context;

    /**
     * __construct
     *
     * @param string                    $label
     * @param TrefwoordChecker $checker
     * @param QueryContext     $context
     */
    public function __construct($label, TrefwoordChecker $checker, QueryContext $context)
    {
        $this->label = $label;
        $this->checker = $checker;
        $this->context = $context;
    }

    /**
     * checkQuery
     *
     * @param QueryItem  $query
     * @param string     $word
     * @return void
     */
    private function checkQuery(Item $query, $word)
    {

        $value = $this->checker->checkTrefwoord($word, $this->context);
        if($value)
        {
            $query->getInterpretaties()->addInterpretatie($this->label, $value);
        }
    }

    /**
     * visitWord
     *
     * @param Word $word
     * @return void 
     */
    public function visitWord(Word $word)
    {
        $this->checkQuery($word, $word->getWord());
    }
    /**
     * visitText
     *
     * @param Text $text
     * @return void 
     */
    public function visitText(Text $text)
    {
        $this->checkQuery($text, $text->getText());
    }
    /**
     * visitText
     *
     * @param ExplicitTerm $term
     * @return void 
     */
    public function visitExplicitTerm(ExplicitTerm $term)
    {
        if($this->label == $term->getNominator()->getWord())
        {
            $term->getTerm()->accept($this);
        }
    }
    /**
     * visitSubExpression
     *
     * @param SubExpression $sub
     * @return void 
     */
    public function visitSubExpression(SubExpression $sub)
    {
        $sub->getSubExpression()->accept($this);
    }
    /**
     * visitNegation
     *
     * @param Negation $negation
     * @return void 
     */
    public function visitNegation(Negation $negation)
    {
        $negation->getSubExpression()->accept($this);
    }
    /**
     * visitDisjunctiveExpressionList
     *
     * @param DisjunctiveExpressionList $list
     * @return void 
     */
    public function visitDisjunctiveExpressionList(DisjunctiveExpressionList $list)
    {
        foreach($list->getExpressions() as $expression)
        {
            $expression->accept($this);
        }
    }
    /**
     * visitConjunctiveExpressionList
     *
     * @param ConjunctiveExpressionList $list
     * @return void 
     */
    public function visitConjunctiveExpressionList(ConjunctiveExpressionList $list)
    {
        foreach($list->getExpressions() as $expression)
        {
            $expression->accept($this);
        }
    }
}
