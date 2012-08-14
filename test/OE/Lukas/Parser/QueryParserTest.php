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
class QueryParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * QueryParser
     */
    protected $parser;

    public function setUp()
    {
        $this->parser = new QueryParser( );
    }

    public function tearDown()
    {
        $this->parser = null;
    }

    /**
     * Test our parser by parsing a string containing a single word.
     *
     * @return void
     */
    public function testParseWord( )
    {
        $this->parser->readString( 'Lukas' );
        $result = $this->parser->parse();
        $this->assertInstanceOf( 'OE\Lukas\QueryTree\Word', $result );
    }

    /**
     * Test our parser by parsing a string containing a text phrase.
     *
     * @return void
     */
    public function testParseText( )
    {
        $this->parser->readString( '"Lukas"' );
        $result = $this->parser->parse();
        $this->assertInstanceOf( 'OE\Lukas\QueryTree\Text', $result );
    }

    /**
     * Test our parser by parsing a string containing an explicit term.
     *
     * @return void
     */
    public function testParseExplicitTerm( )
    {
        $this->parser->readString( 'country:Belgium' );
        $result = $this->parser->parse();
        $this->assertInstanceOf( 'OE\Lukas\QueryTree\ExplicitTerm', $result );
    }

    /**
     * Test our parser by parsing a string containing a negation.
     *
     * @return void
     */
    public function testParseNegation( )
    {
        $this->parser->readString( '-VIOE' );
        $result = $this->parser->parse();
        $this->assertInstanceOf( 'OE\Lukas\QueryTree\Negation', $result );
    }

    /**
     * Test our parser by parsing a string containing two words.
     *
     * @return void
     */
    public function testParseConjunction( )
    {
        $this->parser->readString( 'Lukas Dieter' );
        $result = $this->parser->parse();
        $this->assertInstanceOf( 'OE\Lukas\QueryTree\ConjunctiveExpressionList', $result );
    }

    /**
     * Test our parser by parsing a string containing two words with a boolean 
     * OR operator.
     *
     * @return void
     */
    public function testParseDisjunction( )
    {
        $this->parser->readString( 'Lukas OR Dieter' );
        $result = $this->parser->parse();
        $this->assertInstanceOf( 'OE\Lukas\QueryTree\DisjunctiveExpressionList', $result );
    }

    /**
     * Test parsing of a string containing a subexpression
     *
     * @return void
     */
    public function testeParseSubexpression( )
    {
        $this->parser->readString( '(Lukas)' );
        $result = $this->parser->parse();
        $this->assertInstanceOf( 'OE\Lukas\QueryTree\Subexpression', $result );
    }

    public function testParseUnclosedQuotesError( )
    {
        $this->parser->readString( '"Lukas' );
        $result = $this->parser->parse();
        $this->assertFalse( $result );
        $this->assertTrue( $this->parser->hasFeedback() );
    }

    public function testParseInvalidNegationError( )
    {
        $this->parser->readString( '-"Lukas' );
        $result = $this->parser->parse();
        $this->assertFalse( $result );
        $this->assertTrue( $this->parser->hasFeedback() );
    }

}
