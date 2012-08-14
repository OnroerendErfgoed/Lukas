<?php
/**
 * @package   OE.Lukas
 * @copyright 2012 {@link http://www.vioe.be Vlaams Instituut voor het Onroerend Erfgoed}
 * @author    Dieter Standaert <dieter.standaert@gmail.com>
 * @license   http://opensource.org/licenses/mit-license.php The MIT License
 */

namespace OE\Lukas\QueryTree;

/**
 * ExpressionList
 *
 * @package   OE.Lukas
 * @since     0.1.0
 * @copyright 2012 {@link http://www.vioe.be Vlaams Instituut voor het Onroerend Erfgoed}
 * @author    Dieter Standaert <dieter.standaert@gmail.com>
 * @license   http://opensource.org/licenses/mit-license.php The MIT License
 */
abstract class ExpressionList extends QueryItem implements \IteratorAggregate, \Countable
{
    /**
     * @var expression
     */
    protected $expressions;

    /**
     * __construct
     *
     * @param array
     */
    public function __construct($expressions = array())
    {
        $this->expressions = $expressions;
    }

    /**
     * getExpressions
     *
     * @return array
     */
    public function getExpressions()
    {
        return $this->expressions;
    }

    /**
     * getIterator
     *
     * @return  \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator( $this->expressions );
    }

    /**
     * countExpressions
     *
     * @deprecated
     * @return integer
     */
    public function countExpressions()
    {
        return count($this->expressions);
    }

    /**
     * count
     *
     * @return integer
     */
    public function count()
    {
        return count($this->expressions);
    }

}
