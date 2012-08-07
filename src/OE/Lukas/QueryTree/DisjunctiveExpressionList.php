<?php
/**
 * @package     OE.Lukas
 * @copyright   2012 {@link http://www.vioe.be Vlaams Instituut voor het Onroerend Erfgoed}
 * @author      Dieter Standaert <dieter.standaert@gmail.com>
 * @license   http://opensource.org/licenses/mit-license.php The MIT License
 */

namespace OE\Lukas\QueryTree;

use OE\Lukas\Visitor\IQueryItemVisitor;

/**
 * DisjunctiveExpressionList
 *
 * @package     OE.Lukas
 * @since       0.1.0
 * @copyright   2012 {@link http://www.vioe.be Vlaams Instituut voor het Onroerend Erfgoed}
 * @author      Dieter Standaert <dieter.standaert@gmail.com>
 * @license   http://opensource.org/licenses/mit-license.php The MIT License
 */
class DisjunctiveExpressionList extends ExpressionList
{
    /**
     * toArray
     * 
     * @return array
     */
    public function toArray()
    {
        return array("Operator"=>"AND", "Expressions"=>$this->expressions);
    }

    /**
     * accept
     * 
     * @param   IQueryItemVisitor $visitor
     * @return  void
     */
    public function accept(IQueryItemVisitor $visitor)
    {
        $visitor->visitDisjunctiveExpressionList($this);
    }
}
