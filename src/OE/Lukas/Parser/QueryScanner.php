<?php
/**
 * @package   OE.Lukas
 * @copyright 2012 {@link http://www.vioe.be Vlaams Instituut voor het Onroerend Erfgoed}
 * @author    Dieter Standaert <dieter.standaert@gmail.com>
 * @license   http://opensource.org/licenses/mit-license.php The MIT License
 */

namespace OE\Lukas\Parser;

/**
 * QueryScanner
 * 
 * A simple scanner for search queries. The scanner also functions as tokenizer, returning
 * only tokens and matched strings, instead of feeding character per character. The scanner
 * utilizes PHP built-in regular expressions to match tokens by order of priority. The
 * scanner needs to be steered manually with the "next" function to make it scan the next
 * token.
 * Whitespace tokens are treated as separator between two semantic tokens and are 
 * automatically discarded. Following classic tokenizers, tokens are represented by their:
 * - token type, in form of an integer constant. Technically, PHP can work fine with string
 *   representations for token types, but in this scanner, integers are used and a function
 *   is provided to convert the integer token type to textual representation.
 * - token content, in the form of a string.
 * For debugging and error reporting reasons, the scanner retains all input to be processed, 
 * all input that is processed and the position of the scanner in the original input string.
 *
 * @todo    Refactor EOL token to EOF (end of file) token, or EOI (end of input). 
 *          The EOL token is erronously used by the scanner to denote the end of the
 *          input string.
 *
 * @package   OE.Lukas
 * @since     0.1.0
 * @copyright 2012 {@link http://www.vioe.be Vlaams Instituut voor het Onroerend Erfgoed}
 * @author    Dieter Standaert <dieter.standaert@gmail.com>
 * @license   http://opensource.org/licenses/mit-license.php The MIT License
 */
class QueryScanner
{
    /**
     * EOL
     *  Constante voor "End of Line" tokens. Een "end of line" geeft het
     *  einde van de input aan.
     * @const integer EOL
     */
    const EOL = 0;
    /**
     * WORD
     *  Constante voor een "Word" token.
     * @const integer WORD 
     */
    const WORD = 1;
    /**
     * LPAREN
     *  Een "(" of "Left paren" token. 
     * @const integer LPAREN
     */
    const LPAREN = 2;
    /**
     * RPAREN
     *  Staat voor ")", een "right paren" token.
     * @const integer RPAREN
     */
    const RPAREN = 3;
    /**
     * MINUS
     *  Staat voor "-", een "minus" token.
     * @const integer MINUS
     */
    const MINUS = 4;
    /**
     * COLON
     *  Staat voor ":", een "colon"  token.
     * @const integer COLON
     */
    const COLON = 5;
    /**
     * OROP
     *  Staat voor "OR", als woord. Een "OR operator" token.
     * @const integer OROP
     */
    const OROP = 6;
    /**
     * WSPC
     *  Staat voor elke vorm (en hoeveelheid) van spaties, 
     *  een "Whitespace" token.
     * @const integer WSPC
     */
    const WSPC = 7;
    /**
     * TEXT
     *  Een "TEXT" token staat voor tekst tussen twee 
     *  quotes (dubbele haakjes). Dit wordt reeds door de scanner
     *  opgevangen uit eenvoud voor zowel scanner als parser
     *  en om een volledige parse van de tekst te vermijden.
     * @const integer TEXT
     */
    const TEXT = 8;
    /**
     * ILL
     *  Een illegaal karakter, zoals bijvoorbeeld een controle
     *  karakter of systeem karakter. 
     *  Deze zouden niet mogen voorkomen.
     * @const integer ILL
     */
    const ILL = 9;
    /**
     * QUOTE
     *  '"', een quote token staat voor dubbele haakjes.
     *  Omdat de scanner automatisch alle tekst tussen dubbele
     *  haakjes in een TEXT token zet, wordt deze quote alleen
     *  teruggegeven voor een dubbel haakje zonder bijpassende 
     *  sluitend dubbel haakje. 
     * @const integer QUOTE
     */
    const QUOTE = 10;
    /**
     * processed
     *  De input string die al verwerkt is en in tokens terug-
     *  gegeven.
     * @var string $processed
     */
    private $processed;
    /**
     * input
     *  De input string die nog verwerkt moet worden. Deze 
     *  wordt ingekort naarmate deze verwerkt wordt.
     * @var string $input
     */ 
    private $input;
    /**
     * position
     *  De positie van de scanner t.o.v. de oorspronkelijke
     *  input string.
     * @var integer $position
     */
    private $position;
    /**
     * token
     *  De laatste text/token die de scanner verwerkt heeft.
     * @var string $token
     */
    private $token;
    /**
     * tokenType
     *  Het type token die de scanner verwerkt heeft, 
     *  aangeduid door de constante.
     * @var integer $tokenType
     */
    private $tokenType;

    /**
     * typestrings
     *  De tekstuele representatie van de tokens types.
     * @var array $typestrings
     */
    private $typestrings = array (
        self::EOL => "EOL",
        self::WORD => "WORD",
        self::LPAREN => "LPAREN",
        self::RPAREN => "RPAREN",
        self::MINUS => "MINUS",
        self::COLON => "COLON",
        self::OROP => "OROP",
        self::WSPC => "WHITESPACE",
        self::TEXT => "TEXT",
        self::ILL => "ILLEGAL",
        self::QUOTE => "QUOTE"
    );
    /**
     * regEx
     *  De regular expressions per token type die hun token type
     *  matchen uit de input. Deze expression moeten twee sub-
     *  expressies bevatten: de eerste voor de tekens die matchen
     *  met de token die gescand wordt zelf, de tweede voor de 
     *  resterende tekens in de string (gewoonlijk "(.*)" om alle
     *  overblijvende tekens op te nemen.
     *  Door niet alleen de tekens te beschrijven die -wel- 
     *  matchen krijgen we meer controle op welke tekens niet 
     *  moeten matchen. Bijvoorbeeld voor sleutelwoorden zoals
     *  "OR" kunnen we hier opleggen dat er na "OR" een spatie of
     *  enig niet woord-karakter moet zijn.
     *  De volgorde waarin de reguliere expressies staan bepaalt
     *  ook in welke volgorde de tokens gematched worden. Dit is
     *  belangrijk bij het aanpassen of toevoegen van expressies.
     *  Bijvoorbeeld: sleutelwoorden zullen altijd voor de woord-
     *  token moeten komen, of het sleutelwoord zal als een woord
     *  beschouwd worden.
     *  De controle op een illegaal karakter moet altijd de
     *  laatste zijn, als geen andere expressie matcht.
     *  De whitespace expressie is best op de eerste plaats. 
     * @var array $regEx
     */
    private $regEx = array(
        // WSPC matcht op (veelvuldige) spaties, tabs en newlines.
        self::WSPC => '#^([ \t\n]+)(.*)#',

        // TEXT matcht op alle mogelijke input tussen dubbele haakjes.
        // Dubbele haakjes maken deel uit van de match.
        self::TEXT => '#^(\"[^"]*\")(.*)#',

        // OROP matcht op sleutelwoord "OR" (hoofdletter gevoelig)
        // indien er geen tekst volgt na "OR".
        self::OROP => '#^(OR)(\b.*)#',

        // WORD matcht op letters, cijfers, underscores, koppel-
        // tekens en punten (denk bijv. aan dibe_relict.101)
        // Kan dus niet matchen op afkappings tekens en accenten
        // Deze zullen tussen quotes geplaatst moeten worden.
        self::WORD => '#^([a-zA-Z0-9_][a-zA-Z0-9_\-.]*)(.*)#',

        // parens, haakjes
        self::LPAREN => '#^(\()(.*)#',
        self::RPAREN => '#^(\))(.*)#',

        // koppelteken, dubbel punt, quote
        self::MINUS => '#^(-)(.*)#',
        self::COLON => '#^(:)(.*)#',
        self::QUOTE => '#^(\")([^"]*)$#',

        // Dit mag matchen met elk een karakter dat overblijft.
        self::ILL => '#^(.)(.*)#'
    );

    /**
     * getProcessedData
     *  Geeft het deel van de input string terug dat al verwerkt is.
     * @return string
     */
    public function getProcessedData()
    {
        return $this->processed;
    }

    /**
     * getRemainingData
     *  Geeft het deel van de input string terug dat nog verwerkt moet worden.
     * @return string
     */
    public function getRemainingData()
    {
        return $this->input;
    }

    /**
     * getPosition
     *  Geeft de positie van de scanner in de oorspronkelijke input string terug.
     * @return integer
     */
    public function getPosition()
    {   
        return $this->position;
    }

    /**
     * readString
     *  Leest de nieuwe input string in en zet de positie op 0. De verwerkte data
     *  wordt leeg gemaakt.
     * @param string
     * @return void
     */
    public function readString($inputstring)
    {
        $this->input = $inputstring;
        $this->processed = "";
        $this->position = 0;
    } 

    /**
     * getTokenType
     *  Geeft de token type (constante) terug van de laatst verwerkte token.
     * @return integer
     */
    public function getTokenType()
    {
        return $this->tokenType; 
    }

    /**
     * getTokenTypeText
     *  Geeft de textuele naam van de token type terug van:
     *  - de token type (constante) indien meegegeven
     *  - de laatst verwerkte token indien geen parameter is
     *    meegegeven
     * @return string
     */
    public function getTokenTypeText($tokenType = null)
    {
        if($tokenType == null) 
        {
            $tokenType = $this->tokenType;
        }
        return $this->typestrings[$tokenType]; 
    }

    /**
     * getToken
     *  Geeft de token (tekst) terug van de laatst verwerkte token.
     * @return integer
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * next
     *  Verwerkt de volgende token en geeft het type terug.
     * @return integer
     */
    public function next()
    {
        // Test voor elke token type op beurt
        foreach($this->regEx as $tokenType => $reg) 
        {   
            // negeer de token indien whitespace.
            if($this->testToken($reg, $tokenType) &&($this->getTokenType() != self::WSPC))
            {
                return $this->getTokenType();
            }
        }
        // Indien geen token matcht, zitten we waarschijnlijk
        // aan het einde. De controle is toch ingevoerd, moest
        // de "match all" expressie voor illegale tekens falen.
        if($this->input != "") 
        {
            $this->tokenType = self::ILL; 
            $this->token = $this->input; 
            $this->input = ""; 
            return self::ILL;
        }    
        $this->tokenType = self::EOL; 
        $this->token = null; 
        return self::EOL;
    }

    /**
     * testToken
     *  Hulpfunctie om een expressie te testen op een match en
     *  als token te verwerken.
     * @param string
     * @param integer
     * @return boolean
     */
    private function testToken($regEx, $tokenType)
    {
        $matches = array();
        if (preg_match($regEx, $this->input, $matches))
        {
            $this->token = $matches[1];
            $this->processed .= $matches[1];
            $this->input = $matches[2];
            $this->tokenType = $tokenType;
            $this->position = $this->position + strlen($this->token);
            return true;
        }
        return false;
    }

}
