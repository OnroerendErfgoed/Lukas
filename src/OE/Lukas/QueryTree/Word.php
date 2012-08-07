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
 * Word
 *
 * @package     OE.Lukas
 * @since       0.1.0
 * @copyright   2012 {@link http://www.vioe.be Vlaams Instituut voor het Onroerend Erfgoed}
 * @author      Dieter Standaert <dieter.standaert@gmail.com>
 * @license   http://opensource.org/licenses/mit-license.php The MIT License
 */
class Word extends SimpleTerm
{

    /**
     * __construct
     *
     * @param   string $text
     */
    public function __construct($word)
    {
        parent::__construct(QueryScanner::WORD, $word);
    }

    /**
     * getWord
     *
     * @return  void
     */
    public function getWord()
    {
        return $this->getToken();
    }

    /**
     * toArray
     *
     * @return array
     */
    public function toArray()
    {
        return array("Expression"=>"Word", "Term"=>$this->getToken());
    }

    /**
     * accept
     *
     * @param   IQueryItemVisitor $visitor
     * @return  void
     */
    public function accept(IQueryItemVisitor $visitor)
    {
        $visitor->visitWord($this);
    }
}
