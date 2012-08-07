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
class WordTest extends \PHPUnit_Framework_TestCase
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
    }

    public function tearDown( )
    {
        $this->word = null;
    }

    public function testGetToken( )
    {
        $this->assertEquals( 'Lukas', $this->word->getToken() );
    }

    public function testGetWord( )
    {
        $this->assertEquals( 'Lukas', $this->word->getWord() );
    }

    public function testWordIsToken( )
    {
        $this->assertEquals( $this->word->getWord(), $this->word->getToken() );
    }

    public function testGetTokenType( )
    {
        $this->assertEquals( QueryScanner::WORD, $this->word->getTokenType() );
    }

    public function testToArray( )
    {
        $arr = array( 'Expression' => 'Word', 'Term' => 'Lukas' );
        $this->assertEquals( $arr, $this->word->toArray( ) );
    }

}
