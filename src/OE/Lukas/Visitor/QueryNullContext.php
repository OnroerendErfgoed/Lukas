<?php
/**
 * @package     OE.Lukas
 * @copyright   2012 {@link http://www.vioe.be Vlaams Instituut voor het Onroerend Erfgoed}
 * @author      Dieter Standaert <dieter.standaert@gmail.com> 
 * @license   http://opensource.org/licenses/mit-license.php The MIT License
 */

namespace OE\Lukas\Visitor;

/**
 * QueryNullContext
 *
 * @package     OE.Lukas
 * @since       0.1.0
 * @copyright   2012 {@link http://www.vioe.be Vlaams Instituut voor het Onroerend Erfgoed}
 * @author      Dieter Standaert <dieter.standaert@gmail.com> 
 * @license   http://opensource.org/licenses/mit-license.php The MIT License
 */
class QueryNullContext implements IQueryContext
{
    /**
     * __construct
     *
     */
    public function __construct()
    {
    }

    /**
     * find
     *
     * @param string
     * @return object
     */
    public function find($word)
    {
        return null;
    }

    /**
     * findAll
     *
     * @param string
     * @return array
     */
    public function findAll($word)
    {
        return array();
    }

}
