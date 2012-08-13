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
class ConjunctiveExpressionListTest extends ExpressionListTest
{
    public function setUp()
    {
        parent::setUp();
        $this->expressionList = new ConjunctiveExpressionList( array( $this->Lukas, $this->me ) );
    }

    public function testToArray( )
    {
        $this->assertInternalType( 'array', $this->expressionList->toArray() );
    }

}
