<?php
namespace DoctrineExtensions\Query\Mysql;

use \Doctrine\ORM\Query\AST\Functions\FunctionNode,
	\Doctrine\ORM\Query\Lexer;

/**
 * Adds support for the MySQL Soundex function.
 * 
 * Example: SELECT * FROM Entity\Foo WHERE SOUNDEX(c.name) = SOUNDEX("similar");
 * 
 * @author Timo A. Hummel
 *
 */
class Soundex extends FunctionNode
{
    public $stringPrimary;

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return 'SOUNDEX(' . $sqlWalker->walkSimpleArithmeticExpression($this->stringPrimary).")";
    }

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $lexer = $parser->getLexer();

        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->stringPrimary = $parser->StringPrimary();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
