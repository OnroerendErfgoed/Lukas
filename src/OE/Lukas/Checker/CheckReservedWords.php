<?php
/**
 * @package     OE.Lukas
 * @copyright   2012 {@link http://www.vioe.be Vlaams Instituut voor het Onroerend Erfgoed}
 * @author      Dieter Standaert <dieter.standaert@gmail.com>
 * @license   http://opensource.org/licenses/mit-license.php The MIT License
 */

namespace OE\Lukas\Checker;

/**
 * CheckReservedWords
 *
 * @package     OE.Lukas
 * @since       0.1.0
 * @copyright   2012 {@link http://www.vioe.be Vlaams Instituut voor het Onroerend Erfgoed}
 * @author      Dieter Standaert <dieter.standaert@gmail.com>
 * @license   http://opensource.org/licenses/mit-license.php The MIT License
 */
class CheckReservedWords implements IKeywordChecker
{
    /**
     * words
     *
     * @var array
     */
    private $words;

    /**
     * __construct
     *
     * @param array  $woorden
     * @return void
     */
    public function __construct(array $words)
    {
        $this->words = $words;
    }

    /**
     * Check if the term is one of the registered keywords.
     * 
     * @param   string  $term 
     * @param   mixed   $context
     * @return  mixed   boolean|string False if it's not a keyword.
     */
    public function checkKeyword($term, $context)
    {
        if(array_key_exists($term, $this->words))
        {
            return $this->words[$term];
        } else {
            return false;
        }
    }
}
