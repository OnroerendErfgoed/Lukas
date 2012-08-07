<?php
/**
 * @package   OE.Lukas
 * @copyright 2012 {@link http://www.vioe.be Vlaams Instituut voor het Onroerend Erfgoed}
 * @author    Koen Van Daele <koen.vandaele@rwo.vlaanderen.Be>
 * @license   http://opensource.org/licenses/mit-license.php The MIT License
 */

namespace OE\Lukas\Parser;

/**
 * @package   OE.Lukas
 * @since     0.1.0
 * @copyright 2012 {@link http://www.vioe.be Vlaams Instituut voor het Onroerend Erfgoed}
 * @author    Koen Van Daele <koen.vandaele@rwo.vlaanderen.Be>
 * @license   http://opensource.org/licenses/mit-license.php The MIT License
 */
class QueryScannerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * QueryScanner
     */
    protected $scanner;

    public function setUp()
    {
        $this->scanner = new QueryScanner( );
    }

    public function tearDown()
    {
        $this->scanner = null;
    }

    public function testReadInputString( )
    {
        $this->scanner->readString( 'Lukas' );
        $this->assertEquals( '', $this->scanner->getProcessedData() );
        $this->assertEquals( 'Lukas', $this->scanner->getRemainingData() );
        $this->assertEquals( 0, $this->scanner->getPosition() );
    }

    /**
     * @dataProvider getTestNextWithOneTokenDataprovider
     */
    public function testNextWithOneToken($string, $type)
    {
        $this->scanner->readString( $string );
        $scannedType = $this->scanner->next();
        $this->assertEquals( $type, $scannedType );
    }

    public function getTestNextWithOneTokenDataprovider( )
    {
        return array( 
            array( 'Lukas', QueryScanner::WORD ),
            array( '', QueryScanner::EOL ),
            array( '(', QueryScanner::LPAREN ),
            array( ')', QueryScanner::RPAREN ),
            array( '-', QueryScanner::MINUS ),
            array( ':', QueryScanner::COLON ),
            array( 'OR', QueryScanner::OROP ),
            array( '"Lukas"', QueryScanner::TEXT ),
            array( '"', QueryScanner::QUOTE ),
        );
    }
}
