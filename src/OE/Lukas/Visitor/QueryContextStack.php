<?php
/**
 * @package     OE.Lukas
 * @copyright   2012 {@link http://www.vioe.be Vlaams Instituut voor het Onroerend Erfgoed}
 * @author      Dieter Standaert <dieter.standaert@gmail.com> 
 * @license   http://opensource.org/licenses/mit-license.php The MIT License
 */

namespace OE\Lukas\Visitor;

/**
 * QueryContextStack
 *
 * @package     OE.Lukas
 * @since       0.1.0
 * @copyright   2012 {@link http://www.vioe.be Vlaams Instituut voor het Onroerend Erfgoed}
 * @author      Dieter Standaert <dieter.standaert@gmail.com> 
 * @license   http://opensource.org/licenses/mit-license.php The MIT License
 */
class QueryContextStack implements IQueryContext
{
    /**
     * @var array $contextStack
     */
    private $contextStack;

    /**
     * __construct
     *
     */
    public function __construct()
    {
        $this->contextStack = array();
    }

    /**
     * addContext
     * @param array
     * @return void
     */
    public function addContext($context)
    {
        array_push($this->contextStack, $context);
    }

    /**
     * removeContext
     * @return void
     */
    public function removeContext()
    {
        array_pop($this->contextStack);
    }

    /**
     * find
     * @param string $word
     * @return object
     */
    public function find($word)
    {
        return null;
    }
    /**
     * findAll
     * @param array $word
     * @return object
     */
    public function findAll($word)
    {
        return array();
    }
}
