<?php
/**
 * @package   OE.Lukas
 * @copyright 2012 {@link http://www.vioe.be Vlaams Instituut voor het Onroerend Erfgoed}
 * @author    Koen Van Daele <koen.vandaele@rwo.vlaanderen.Be>
 * @license   http://opensource.org/licenses/mit-license.php The MIT License
 */

use OE\Lukas\Checker\CheckReservedWords;

/**
 * @package   OE.Lukas
 * @since     0.1.0
 * @copyright 2012 {@link http://www.vioe.be Vlaams Instituut voor het Onroerend Erfgoed}
 * @author    Koen Van Daele <koen.vandaele@rwo.vlaanderen.Be>
 * @license   http://opensource.org/licenses/mit-license.php The MIT License
 */
class CheckReservedWordsTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var CheckReservedWords
     */
    protected $checker;

    public function setUp(  )
    {
        $this->checker = new CheckReservedWords( 
            array( 'photo' => 'image',
                   'test' => 'test' ) );
    }

    public function tearDown( )
    {
        $this->checker = null;
    }

    /**
     * @dataProvider getTestExpectedValueDataProvider
     */
    public function testExpectedValue( $keyword, $result )
    {
        $this->assertEquals( $result, $this->checker->checkKeyword( $keyword, null ) );
    }

    public function getTestExpectedValueDataProvider(  )
    {
        return array( 
            array( 'test', 'test' ),
            array( 'photo', 'image' ),
            array( 'Lukas', false ),
            array( 'image', false ) 
        );
    }
}
