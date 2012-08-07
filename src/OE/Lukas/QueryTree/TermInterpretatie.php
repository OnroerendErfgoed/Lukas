<?php
/**
 * @package     OE.Lukas
 * @copyright   2012 {@link http://www.vioe.be Vlaams Instituut voor het Onroerend Erfgoed}
 * @author      Dieter Standaert <dieter.standaert@gmail.com>
 * @license   http://opensource.org/licenses/mit-license.php The MIT License
 */

namespace OE\Lukas\QueryTree;

/**
 * TermInterpretatie
 *
 * @package     OE.Lukas
 * @since       0.1.0
 * @copyright   2012 {@link http://www.vioe.be Vlaams Instituut voor het Onroerend Erfgoed}
 * @author      Dieter Standaert <dieter.standaert@gmail.com>
 * @license   http://opensource.org/licenses/mit-license.php The MIT License
 */
class TermInterpretatie
{
    /**
     * @var expression
     */
    private $interpretaties;

    /**
     * __construct
     *
     * @param array
     */
    public function __construct($interpretaties = array())
    {
        $this->interpretaties = $interpretaties;
    }

    /**
     * addInterpretatie
     *
     * @param string
     * @param string
     * @return void
     */
    public function addInterpretatie($label, $waarde)
    {
        if(array_key_exists($label, $this->interpretaties))
        {
            $this->interpretaties[$label][] = $waarde;
        } else {
            $this->interpretaties[$label] = array($waarde);
        }        
    }

    /**
     * addInterpretaties
     * 
     * @param string
     * @param array
     * @return void
     */
    public function addInterpretaties($label, $waarden)
    {
        if(array_key_exists($label, $this->interpretaties))
        {
            $this->interpretaties[$label] = array_merge($this->interpretaties[$label], $waarden);
        } else {
            $this->interpretaties[$label] = array($waarde);
        }    
    }

    /**
     * hasInterpretaties
     * 
     * @return boolean
     */
    public function hasInterpretaties()
    {
        return sizeof($this->interpretaties) > 0;
    }

    /**
     * hasInterpretatie
     * 
     * @param string
     * @return boolean
     */
    public function hasInterpretatie($label)
    {
        return array_key_exists($label, $this->interpretaties);
    }

    /**
     * getInterpretaties
     * 
     * @param string
     * @return object
     */
    public function getInterpretaties($label)
    {
        return $this->interpretaties[$label];
    }

}
