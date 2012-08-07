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
class TextTest extends \PHPUnit_Framework_TestCase
{
    /**
     * text
     *
     * @var Text
     */
    protected $text;

    public function setUp( )
    {
        $this->text = new Text( '"Lukas"' );
    }

    public function tearDown( )
    {
        $this->text = null;
    }

    public function testGetToken( )
    {
        $this->assertEquals( 'Lukas', $this->text->getToken() );
    }

    public function testGetText( )
    {
        $this->assertEquals( 'Lukas', $this->text->getText() );
    }

    public function testGetQuotedText( )
    {
        $this->assertEquals( '"Lukas"', $this->text->getQuotedText() );
    }
    
    public function testStripQuotes( )
    {
        $this->assertEquals( 'Lukas', $this->text->stripQuotes('"Lukas"') );
        $this->assertEquals( '', $this->text->stripQuotes('') );
    }



    public function testTextIsToken( )
    {
        $this->assertEquals( $this->text->getText(), $this->text->getToken() );
    }

    public function testGetTokenType( )
    {
        $this->assertEquals( QueryScanner::TEXT, $this->text->getTokenType() );
    }

    public function testToArray( )
    {
        $arr = array( 'Expression' => 'Text', 'Term' => 'Lukas' );
        $this->assertEquals( $arr, $this->text->toArray( ) );
    }

}
