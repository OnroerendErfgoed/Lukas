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
class ExplicitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * word
     *
     * @var Word
     */
    protected $word;

    public function setUp( )
    {
        $this->word = new Word( 'Lukas' );
        $this->explicit = new ExplicitTerm( 'people', $this->word );
    }

    public function tearDown( )
    {
        $this->word = null;
        $this->explicit = null;
    }

    public function testGetNominator( )
    {
        $this->assertEquals( 'people', $this->explicit->getNominator() );
    }

    public function testGetTerm( )
    {
        $this->assertEquals( $this->word, $this->explicit->getTerm() );
    }

    public function testToArray( )
    {
        $arr = array( 'Expression' => 'Explicit Term', 
                      'Nominator' => 'people',
                      'Term' => $this->word );
        $this->assertEquals( $arr, $this->explicit->toArray( ) );
    }

}
