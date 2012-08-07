<?php
/**
 * @package     OE.Lukas
 * @copyright   2012 {@link http://www.vioe.be Vlaams Instituut voor het Onroerend Erfgoed}
 * @author      Dieter Standaert <dieter.standaert@gmail.com> 
 * @license   http://opensource.org/licenses/mit-license.php The MIT License
 */

namespace OE\Lukas\Visitor;

/**
 * IQueryContext
 *
 * @package     OE.Lukas
 * @since       0.1.0
 * @copyright   2012 {@link http://www.vioe.be Vlaams Instituut voor het Onroerend Erfgoed}
 * @author      Dieter Standaert <dieter.standaert@gmail.com> 
 * @license   http://opensource.org/licenses/mit-license.php The MIT License
 */
interface IQueryContext
{
    /**
     * find
     *
     * @param string
     * @return object
     */
    public function find($word);

    /**
     * findAll
     *
     * @param string
     * @return array
     */
    public function findAll($word);
}
