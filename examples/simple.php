<?php

$loader = require_once( __DIR__ . '/../vendor/autoload.php' );

use OE\Lukas\Parser\QueryParser;
use OE\Lukas\Visitor\QueryItemPrinter;

$parser = new QueryParser();
$parser->readString( 'Lukas AND me' );
$query = $parser->parse();

$v = new QueryItemPrinter();
$query->accept($v);
