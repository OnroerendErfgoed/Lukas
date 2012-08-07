<?php
/**
 * @package     OE.Lukas
 * @copyright   2012 {@link http://www.vioe.be Vlaams Instituut voor het Onroerend Erfgoed}
 * @author      Dieter Standaert <dieter.standaert@gmail.com>
 * @license   http://opensource.org/licenses/mit-license.php The MIT License
 */

namespace OE\Lukas\QueryTree;

use OE\Lukas\Visitor\IQueryItemVisitor;

/**
 * ExplicitTerm
 *
 * @package     OE.Lukas
 * @since       0.1.0
 * @copyright   2012 {@link http://www.vioe.be Vlaams Instituut voor het Onroerend Erfgoed}
 * @author      Dieter Standaert <dieter.standaert@gmail.com>
 * @license   http://opensource.org/licenses/mit-license.php The MIT License
 */
class ExplicitTerm extends SingleTerm
{
    /**
     * @var string $nominator
     */
    protected $nominator;

    /**
     * @var string $token
     */
    protected $term;

    /**
     * __construct
     *
     * @param string $nominator
     * @param SimpleTerm $term
     */
    public function __construct($nominator, SimpleTerm $term)
    {
        parent::__construct();
        $this->nominator = $nominator;
        $this->term = $term;
    }

    /**
     * getNominator
     * 
     * @return string
     */
    public function getNominator()
    {
        return $this->nominator;
    }

    /**
     * getTerm
     *
     * @return SimpleTerm
     */
    public function getTerm()
    {
        return $this->term;
    }

    /**
     * toArray
     * 
     * @return array
     */
    public function toArray()
    {
        return array( "Expression" => "Explicit Term", 
                      "Nominator" => $this->nominator, 
                      "Term"=>$this->term);
    }

    /**
     * accept
     * 
     * @param   IQueryItemVisitor $visitor
     * @return  void
     */
    public function accept(IQueryItemVisitor $visitor)
    {
        $visitor->visitExplicitTerm($this);
    }

}
