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
abstract class ExpressionListTest extends \PHPUnit_Framework_TestCase
{
    protected $Lukas;

    protected $me;

    /**
     * expressionList
     *
     * @var ExpressionList
     */
    protected $expressionList;

    public function setUp()
    {
        $this->Lukas = new Word( 'Lukas' );
        $this->me = new Word( 'me' );
    }

    public function tearDown()
    {
        $this->Lukas = null;
        $this->me = null;
        $this->expressionList = null;
    }

    public function testGetExpressions()
    {
        $this->assertEquals( array( $this->Lukas, $this->me ),
                             $this->expressionList->getExpressions() );
    }

    public function testCount()
    {
        $this->assertEquals(2, count($this->expressionList));
    }
}
