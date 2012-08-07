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
 * QueryItemPrinter
 *
 * @package     OEPS.util
 * @subpackage  zoeken
 * @since       juli 2012
 * @copyright   2012 {@link http://www.vioe.be Vlaams Instituut voor het Onroerend Erfgoed}
 * @author      Dieter Standaert <dieter.standaert@hp.com> 
 * @license   http://opensource.org/licenses/mit-license.php The MIT License
 */
class QueryItemPrinter implements IQueryItemVisitor
{
    /**
     * @var integer depth
     */
    private $depth;

    /**
     * __construct
     */
    public function __construct()
    {
        $this->depth = 0;
    }

    /**
     * indent
     *
     * @return string
     */
    private function indent()
    {
        return str_repeat("#", $this->depth) . " ";
    }

    /**
     * increaseIndent
     *
     * @return void 
     */
    private function increaseIndent()
    {
        $this->depth +=1 ;
    }

    /**
     * decreaseIndent
     *
     * @return void 
     */
    private function decreaseIndent()
    {
        if($this->depth > 0 ) 
        {
            $this->depth -=1 ;
        }
    }

    /**
     * printIndentedLine
     *
     * @param string
     * @return void 
     */
    private function printIndentedLine($line)
    {
        echo $this->indent() . $line . "\n";
    }

    /**
     * visitWord
     *
     * @param Word
     * @return void 
     */
    public function visitWord(Word $word)
    {
        $this->printIndentedLine("Word: " . $word->getWord());
    }

    /**
     * visitText
     *
     * @param Text
     * @return void
     */
    public function visitText(Text $text)
    {
        $this->printIndentedLine("Text: " . $text->getText());
    }

    /**
     * visitExplicitTerm
     *
     * @param ExplicitTerm
     * @return void
     */
    public function visitExplicitTerm(ExplicitTerm $term)
    {
        $this->printIndentedLine("Term: " . $term->getNominator()->getWord() . " - " . $term->getTerm()->getToken());
    }

    /**
     * visitSubExpression
     *
     * @param SubExpression
     * @return void
     */
    public function visitSubExpression(SubExpression $sub)
    {
        $this->printIndentedLine("Subexpression");
        $this->increaseIndent();
        $sub->getSubExpression()->accept($this);
        $this->decreaseIndent();
    }

    /**
     * visitNegation
     *
     * @param Negation
     * @return void 
     */
    public function visitNegation(Negation $negation)
    {
        $this->printIndentedLine("Negation");
        $this->increaseIndent();
        $negation->getSubExpression()->accept($this);
        $this->decreaseIndent();
    }

    /**
     * visitDisjunctiveExpressionList
     *
     * @param DisjunctiveExpressionList
     * @return void 
     */
    public function visitDisjunctiveExpressionList(DisjunctiveExpressionList $list)
    {
        $this->printIndentedLine("Disjunction");
        $this->increaseIndent();
        foreach($list->getExpressions() as $expression)
        {
            $expression->accept($this);
        }
        $this->decreaseIndent();
    }

    /**
     * visitConjunctiveExpressionList
     *
     * @param ConjunctiveExpressionList
     * @return void 
     */
    public function visitConjunctiveExpressionList(ConjunctiveExpressionList $list)
    {
        $this->printIndentedLine("Conjunction");
        $this->increaseIndent();
        foreach($list->getExpressions() as $expression)
        {
            $expression->accept($this);
        }
        $this->decreaseIndent();
    }

}
