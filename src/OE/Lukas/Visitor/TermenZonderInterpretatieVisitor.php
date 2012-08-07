<?php
/**
 * @package     OE.Lukas
 * @copyright   2012 {@link http://www.vioe.be Vlaams Instituut voor het Onroerend Erfgoed}
 * @author      Dieter Standaert <dieter.standaert@gmail.com> 
 * @license   http://opensource.org/licenses/mit-license.php The MIT License
 */

namespace OE\Lukas\Visitor;

use OE\Lukas\QueryTree\Item;
use OE\Lukas\QueryTree\SingleTerm;
use OE\Lukas\QueryTree\Word;
use OE\Lukas\QueryTree\Text;
use OE\Lukas\QueryTree\ExplicitTerm;
use OE\Lukas\QueryTree\SubExpression;
use OE\Lukas\QueryTree\Negation;
use OE\Lukas\QueryTree\DisjunctiveExpressionList;
use OE\Lukas\QueryTree\ConjunctiveExpressionList;

/**
 * TermenZonderInterpretatieVisitor
 *
 * @package     OE.Lukas
 * @since       0.1.0
 * @copyright   2012 {@link http://www.vioe.be Vlaams Instituut voor het Onroerend Erfgoed}
 * @author      Dieter Standaert <dieter.standaert@hp.com> 
 * @license   http://opensource.org/licenses/mit-license.php The MIT License
 */
class TermenZonderInterpretatieVisitor implements IQueryItemVisitor
{
    /**
     * @var string
     */
    private $termen;

    /**
     * __construct
     *
     */
    public function __construct()
    {
        $this->termen = array();
    }


    /**
     * getTermen
     *
     * @return string                $word
     */
    public function getTermen()
    {
        return $this->termen;
    }

    /**
     * checkTerm
     *
     * @param SingleTerm  $term
     * @param string                $word
     * @return void
     */
    private function checkTerm(SingleTerm $term)
    {
        if(! $term->getInterpretaties()->hasInterpretaties())
        {
            $this->termen[] = $term;
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
        $this->checkTerm($word);
    }
    /**
     * visitText
     *
     * @param Text $text
     * @return void 
     */
    public function visitText(Text $text)
    {
        $this->checkTerm($text);
    }
    /**
     * visitExplicitText
     *
     * @param ExplicitTerm $term
     * @return void 
     */
    public function visitExplicitTerm(ExplicitTerm $term)
    {
        $term->getTerm()->accept($this);
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
