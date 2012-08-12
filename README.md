Lukas - Search Query Handler
============================

Lukas is a library that helps in implementing a custom search query language. 
It offers some standard features users have come to expect from text driven search
like boolean operators and subexpressions.

Lukas can also help you implement custom behaviour for certain keywords, you 
might for eg. define that keyword "photo" to mean "search for things that have a
photo".

Unit Tests
----------

[![Build Status](https://secure.travis-ci.org/OnroerendErfgoed/Lukas.png?branch=master)](http://travis-ci.org/OnroerendErfgoed/Lukas)


Query Syntax
------------

The Lukas query parser supports a fairly universal search query standard. It is 
meant to support the most common search combinations while be fairly simple to 
use by non-technical users.

It supports the following features:
 * Keywords are split on whitespace, eg. _Lukas me_ contains two keywords.
 * Keywords can be grouped using quotation marks, eg. _"Lukas me"_ only contains 
   one keyword.
 * Keywords can be combined using boolean and, eg. _Lukas AND me_. This is also
   the default combination, so _Lukas me_ is the same as _Lukas AND me_. 
 * Keywords can be combined using boolean or, eg. _Lukas OR me_.
 * Keywords can be negated using boolean, written as _-keyword_, eg. _-Lukas_.
 * Combinational logic can be specified using parentheses, eg. _Lukas OR (me AND you)_.
 * A keyword can be explicitely marked as belonging to a certain domain, 
   eg. _people:Lukas_.
