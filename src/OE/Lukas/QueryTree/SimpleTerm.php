<?php
/**
 * @package     OE.Lukas
 * @copyright   2012 {@link http://www.vioe.be Vlaams Instituut voor het Onroerend Erfgoed}
 * @author      Dieter Standaert <dieter.standaert@gmail.com>
 * @license   http://opensource.org/licenses/mit-license.php The MIT License
 */

namespace OE\Lukas\QueryTree;

/**
 * SimpleTerm
 *
 * @package     OE.Lukas
 * @since       0.1.0
 * @copyright   2012 {@link http://www.vioe.be Vlaams Instituut voor het Onroerend Erfgoed}
 * @author      Dieter Standaert <dieter.standaert@gmail.com>
 * @license   http://opensource.org/licenses/mit-license.php The MIT License
 */
abstract class SimpleTerm extends SingleTerm
{

    /**
     * @var string $token
     */
    protected $token;

    /**
     * @var integer $tokenType
     */
    protected $tokenType;

    /**
     * __construct
     *
     * @param integer $tokenType
     * @param string $token
     */
    public function __construct($tokenType, $token)
    {
        parent::__construct();
        $this->token = $token;
        $this->tokenType = $tokenType;

    }

    /**
     * getToken
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * getTokenType
     *
     * @return integer
     */
    public function getTokenType()
    {
        return $this->tokenType;
    }

}
