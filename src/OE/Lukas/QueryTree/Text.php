<?php
/**
 * @package     OE.Lukas
 * @copyright   2012 {@link http://www.vioe.be Vlaams Instituut voor het Onroerend Erfgoed}
 * @author      Dieter Standaert <dieter.standaert@gmail.com>
 * @license   http://opensource.org/licenses/mit-license.php The MIT License
 */

namespace OE\Lukas\QueryTree;

use OE\Lukas\Parser\QueryScanner;
use OE\Lukas\Visitor\IQueryItemVisitor;

/**
 * Text
 *
 * @package     OE.Lukas
 * @since       0.1.0
 * @copyright   2012 {@link http://www.vioe.be Vlaams Instituut voor het Onroerend Erfgoed}
 * @author      Dieter Standaert <dieter.standaert@gmail.com>
 * @license   http://opensource.org/licenses/mit-license.php The MIT License
 */
class Text extends SimpleTerm
{

    /**
     * __construct
     * 
     * @param   string $text
     */
    public function __construct($text)
    {
        parent::__construct(QueryScanner::TEXT, $this->stripQuotes($text));
    }

    /**
     * getText
     * 
     * @return  string
     */
    public function getText()
    {
        return $this->getToken();
    }

    /**
     * getQuotedText
     * 
     * @return  string
     */
    public function getQuotedText()
    {
        return '"'.$this->getText().'"';
    }

    /**
     * toArray
     * 
     * @return array
     */
    public function toArray()
    {
        return array("Expression"=>"Text", "Term"=>$this->getToken());
    }

    /**
     * stripQuotes
     * 
     * @return  string
     */
    public function stripQuotes($text)
    {
        if(strlen($text)>2) {
            return substr($text,1,strlen($text)-2);
        } else {
            return $text;
        }
    }

    /**
     * accept
     * 
     * @param   IQueryItemVisitor $visitor
     * @return  void
     */
    public function accept(IQueryItemVisitor $visitor)
    {
        $visitor->visitText($this);
    }
}
