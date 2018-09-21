<?php

namespace Drupal\Tests\parser_sample\Unit;

use Drupal\parser_sample\Myparser\Operator;
use Drupal\Tests\UnitTestCase;
use Drupal\parser_sample\Myparser\Lexer;
use Drupal\parser_sample\Myparser\Token;

/**
 * Tests the LexerTest class.
 *
 * @group LexerTest
 */
class LexerTest extends UnitTestCase
{
    protected $lexer;

    public function testTrueAssertToTrue(){
        $this->assertTrue(true);
    }

    /**
     * Before a test method is run, setUp() is invoked.
     * Create new unit object.
     */
    public function setUp()
    {
        $this->lexer = new Lexer();
    }

    public function testCanCreateLexer()
    {
        $this->assertInstanceOf('Drupal\parser_sample\Myparser\Lexer', $this->lexer);
    }

    /**
     * tokenization (lexing) to ensure that asserts pass.
     */
    public function testToken() {
        $tokens[] = new Token((float)2, Token::T_OPERAND);
        $tokens[] = new Operator('+',0,Operator::O_LEFT_ASSOCIATIVE );
        $tokens[] = new Token((float)2, Token::T_OPERAND);

        $tokenize = $this->lexer->tokenize('2 + 2');

        $this->assertEquals($tokens, $tokenize);
    }

    /**
     * tokenization (lexing) to ensure that asserts do not pass.
     */
    public function testTokenFail() {
        $tokens[] = new Token((float)2, Token::T_OPERAND);
        $tokens[] = new Operator('+',0,Operator::O_LEFT_ASSOCIATIVE );
        $tokens[] = new Token((float)2, Token::T_OPERAND);

        $tokenize = $this->lexer->tokenize('2 + 3');

        $this->assertNotEquals($tokens, $tokenize);
    }


    /**
     * Once test method has finished running, whether it succeeded or failed, tearDown() will be invoked.
     * Unset the $unit object.
     */
    public function tearDown()
    {
        unset($this->lexer);
    }

}