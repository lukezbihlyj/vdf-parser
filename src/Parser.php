<?php

namespace VdfParser;

/**
 * @package VdfParser\Parser
 */
class Parser
{
    /**
     * @var string
     */
    const BRACKET_OPEN = '{';

    /**
     * @var string
     */
    const BRACKET_CLOSE = '}';

    /**
     * @var string
     */
    const QUOTATION_MARK = '"';

    /**
     * @var string
     */
    const BACKSLASH = '\\';

    /**
     * @param string $input
     * @return array
     */
    public function parse($input)
    {
        $result = [];
        $input = trim(preg_replace('#^\s*//.+$#m', '', $input));

        $inKey = false;
        $inValue = false;
        $inSubArray = false;
        $openBracketCount = 0;

        $buffer = null;
        $key = null;
        $value = null;
        $lastChar = null;

        for ($i = 0; $i < strlen($input); $i++) {
            $char = $input[$i];

            if ($inSubArray) {
                if ($lastChar == self::BACKSLASH) {
                    $buffer .= $char;
                } else {
                    if ($char == self::BRACKET_CLOSE && $openBracketCount == 0) {
                        $value = $this->parse(trim($buffer));
                        $buffer = null;
                        $inSubArray = false;

                        if (!is_null($key)) {
                            $result[$key] = $value;
                        } else {
                            $result = $value;
                        }

                        $key = null;
                        $value = null;
                    } elseif ($char == self::BRACKET_CLOSE) {
                        $openBracketCount--;
                        $buffer .= $char;
                    } elseif ($char == self::BRACKET_OPEN) {
                        $openBracketCount++;
                        $buffer .= $char;
                    } else {
                        $buffer .= $char;
                    }
                }
            } elseif ($inKey) {
                if ($char == self::QUOTATION_MARK && $lastChar !== self::BACKSLASH) {
                    $key = $buffer;
                    $buffer = null;
                    $inKey = false;
                } elseif ($char !== self::BACKSLASH) {
                    $buffer .= $char;
                }
            } elseif ($inValue) {
                if ($char == self::QUOTATION_MARK && $lastChar !== self::BACKSLASH) {
                    $value = $buffer;
                    $buffer = null;
                    $inValue = false;

                    $result[$key] = $value;
                    $key = null;
                    $value = null;
                } elseif ($char !== self::BACKSLASH) {
                    $buffer .= $char;
                }
            } else {
                if ($char == self::QUOTATION_MARK && is_null($key)) {
                    $inKey = true;
                } elseif ($char == self::QUOTATION_MARK && is_null($value)) {
                    $inValue = true;
                } elseif ($char == self::BRACKET_OPEN) {
                    $inSubArray = true;
                    $openBracketCount = 0;
                }
            }

            $lastChar = $char;
        }

        return $result;
    }
}
