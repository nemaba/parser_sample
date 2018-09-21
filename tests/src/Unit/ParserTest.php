<?php

namespace Drupal\Tests\parser_sample\Unit;

use Drupal\Tests\UnitTestCase;
use Drupal\parser_sample\Myparser\Parser;

/**
 * Simple test to ensure that asserts pass.
 *
 * @coversDefaultClass Drupal\parser_sample\Myparser\Parser
 * @group phpunit_example
 */
class ParserTest extends UnitTestCase
{
    protected $parser;

    public function testTrueAssertToTrue(){
        $this->assertTrue(true);
    }

    /**
     * Before a test method is run, setUp() is invoked.
     * Create new unit object.
     */
    public function setUp()
    {
        $this->parser = new Parser();
    }

    public function testCanCreateParser()
    {
        $this->assertInstanceOf('Drupal\parser_sample\Myparser\Parser', $this->parser);
    }

    /**
     * Data provider for testEvaluate().
     *
     * @return array
     *   Nested arrays of values to check:
     */
    public function parserDataProvider() {
        return [
            [3 - 1, 2],
            [10 + 20 - 30 + 15 * 5, 75],
            [10 + 20 - 30 + 15 * 5 + 100, 175]
        ];
    }

    /**
     * @covers ::evaluate
     * @dataProvider parserDataProvider
     */
    public function testEvaluate($expression, $expected) {
        $this->assertEquals($expected, $this->parser->evaluate($expression));
    }


    /**
     * Once test method has finished running, whether it succeeded or failed, tearDown() will be invoked.
     * Unset the $unit object.
     */
    public function tearDown()
    {
        unset($this->parser);
    }

}