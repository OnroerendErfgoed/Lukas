<?php
/**
 * @package     OE.Lukas
 * @copyright   2012 {@link http://www.vioe.be Vlaams Instituut voor het Onroerend Erfgoed}
 * @author      Dieter Standaert <dieter.standaert@gmail.com> 
 * @license   http://opensource.org/licenses/mit-license.php The MIT License
 */

namespace OE\Lukas\Visitor;

use OE\Lukas\QueryTree\Word;
use OE\Lukas\QueryTree\Text;
use OE\Lukas\QueryTree\ExplicitTerm;

use OE\Lukas\QueryTree\SubExpression;
use OE\Lukas\QueryTree\Negation;
use OE\Lukas\QueryTree\DisjunctiveExpressionList;
use OE\Lukas\QueryTree\ConjunctiveExpressionList;

/**
 * IQueryItemVisitor
 *
 * @package     OE.Lukas
 * @since       0.1.0
 * @copyright   2012 {@link http://www.vioe.be Vlaams Instituut voor het Onroerend Erfgoed}
 * @author      Dieter Standaert <dieter.standaert@gmail.com> 
 * @license   http://opensource.org/licenses/mit-license.php The MIT License
 */
interface IQueryItemVisitor
{
    /**
     * visitWord
     * @param Word
     * @return void
     */
    public function visitWord(Word $word);

    /**
     * visitText
     * @param Text
     * @return void
     */
    public function visitText(Text $text);

    /**
     * visitExplicitTerm
     * @param ExplicitTerm
     * @return void
     */
    public function visitExplicitTerm(ExplicitTerm $term);

    /**
     * visitSubExpression
     * @param SubExpression
     * @return void
     */
    public function visitSubExpression(SubExpression $sub);

    /**
     * visitNegation
     * @param Negation
     * @return void
     */
    public function visitNegation(Negation $negation);

    /**
     * visitDisjunctiveExpressionList
     * @param DisjunctiveExpressionList
     * @return void
     */
    public function visitDisjunctiveExpressionList(DisjunctiveExpressionList $list);

    /**
     * visitConjunctiveExpressionList
     * @param QueryConjunctiveExpressionList
     * @return void
     */
    public function visitConjunctiveExpressionList(ConjunctiveExpressionList $list);
}

?>
