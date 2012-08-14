<?php
/**
 * @package   OE.Lukas
 * @copyright 2012 {@link http://www.vioe.be Vlaams Instituut voor het Onroerend Erfgoed}
 * @author    Koen Van Daele <koen.vandaele@rwo.vlaanderen.Be>
 * @license   http://opensource.org/licenses/mit-license.php The MIT License
 */

namespace OE\Lukas\QueryTree;

use OE\Lukas\Parser\QueryScanner;

/**
 * @package   OE.Lukas
 * @since     0.1.0
 * @copyright 2012 {@link http://www.vioe.be Vlaams Instituut voor het Onroerend Erfgoed}
 * @author    Koen Van Daele <koen.vandaele@rwo.vlaanderen.Be>
 * @license   http://opensource.org/licenses/mit-license.php The MIT License
 */
class NegationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * word
     *
     * @var Word
     */
    protected $word;

    /**
     * negation
     *
     * @var Negation
     */
    protected $negation;

    public function setUp( )
    {
        $this->word = new Word( 'Lukas' );
        $this->negation = new Negation( $this->word );
    }

    public function tearDown( )
    {
        $this->word = null;
        $this->negation = null;
    }

    public function testGetSubexpression( )
    {
        $this->assertSame( $this->word, $this->negation->getSubexpression() );
    }

    public function testToArray( )
    {
        $arr = array( 'Operator' => 'NOT', 'Expression' => $this->word );
        $this->assertEquals( $arr, $this->negation->toArray( ) );
    }

}
