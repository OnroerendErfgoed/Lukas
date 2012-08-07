<?php
/**
 * @package     OE.Lukas
 * @copyright   2012 {@link http://www.vioe.be Vlaams Instituut voor het Onroerend Erfgoed}
 * @author      Dieter Standaert <dieter.standaert@gmail.com>
 * @license   http://opensource.org/licenses/mit-license.php The MIT License
 */

namespace OE\Lukas\QueryTree;

/**
 * SingleTerm
 *
 * @package     OE.Lukas
 * @since       0.1.0
 * @copyright   2012 {@link http://www.vioe.be Vlaams Instituut voor het Onroerend Erfgoed}
 * @author      Dieter Standaert <dieter.standaert@gmail.com>
 * @license   http://opensource.org/licenses/mit-license.php The MIT License
 */
abstract class SingleTerm extends QueryItem
{
    /**
     * @var TermInterpretatie
     */
    protected $interpretaties;

    /**
     * __construct
     *
     */
    public function __construct()
    {
        $this->interpretaties = new TermInterpretatie();
    }

    /**
     * getInterpretaties
     *
     * @return TermInterpretatie
     */
    public function getInterpretaties()
    {
        return $this->interpretaties;
    }

}
