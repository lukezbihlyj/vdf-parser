<?php

namespace VdfParser;

use PHPUnit_Framework_TestCase as TestCase;
use VdfParser\Parser;

/**
 * @coversDefaultClass VdfParser\Parser
 */
class ParserTest extends TestCase
{
    /**
     * @var VdfParser\Parser
     */
    private $parser;

    /**
     * @return self
     */
    public function setUp()
    {
        $this->parser = new Parser;

        return $this;
    }

    /**
     * @covers ::parse
     */
    public function testParseWorksWithSimpleStrings()
    {
        $vdf = <<<VDF
{
    "one" "This is string number one."
    "two" "This is string number two."
    "three" "This is string number \"three\"."
}
VDF;

        $result = [
            'one' => 'This is string number one.',
            'two' => 'This is string number two.',
            'three' => 'This is string number "three".',
        ];

        $this->assertEquals($result, $this->parser->parse($vdf));
    }

    /**
     * @covers ::parse
     */
    public function testParseWorksWithSubArrays()
    {
        $vdf = <<<VDF
{
    "one" {
        "inner" "This is a sub-array element."
    }
    "two" {
        "inner" "This is a sub-array element."
    }
}
VDF;

        $result = [
            'one' => [
                'inner' => 'This is a sub-array element.',
            ],
            'two' => [
                'inner' => 'This is a sub-array element.',
            ],
        ];

        $this->assertEquals($result, $this->parser->parse($vdf));
    }

    /**
     * @covers ::parse
     */
    public function testParseAllowsRandomWhitespace()
    {
        $vdf = <<<VDF
{
    "one" {

  "inner" "This is a sub-array element."
}}
VDF;

        $result = [
            'one' => [
                'inner' => 'This is a sub-array element.',
            ],
        ];

        $this->assertEquals($result, $this->parser->parse($vdf));
    }

    /**
     * @covers ::parse
     */
    public function testParseAllowsComments()
    {
        $vdf = <<<VDF
{
    // This is a comment, ignore me.
    "one" {
        "inner" "This is a sub-array element." // Ignore me also.
        // Don't load me. "ignore" "me"
    }
}
VDF;

        $result = [
            'one' => [
                'inner' => 'This is a sub-array element.',
            ],
        ];

        $this->assertEquals($result, $this->parser->parse($vdf));
    }
}
