<?php

declare(strict_types=1);

namespace App;

/**
 * Class LetterReverser
 *
 * Without regex.
 */
class LetterReverser
{
    /**
     * Reverse letters in each word of the input text, keeping Uppercase indexes and punctuation.
     *
     * @param string $text The input string to process
     * @return string The processed string with letters in each word reversed
     */
    public function reverse(string $text): string
    {
        $length = mb_strlen($text);
        if ($length <= 1) {
            return $text;
        }
        
        $wordSplitters = ['-', '`', "'"];
        $result = '';
        $buffer = '';

        for ($i = 0; $i < $length; $i++) {
            $char = mb_substr($text, $i, 1);

            if ($char === ' ' || $char === "\n") {
                $result .= $this->processWord($buffer);
                $buffer = '';
                $result .= $char;
            } elseif (in_array($char, $wordSplitters, true)) {
                $result .= $this->processWord($buffer);
                $buffer = '';
                $result .= $char;
            } else {
                $buffer .= $char;
            }
        }

        return $result . $this->processWord($buffer);
    }

    /**
     * Reverse letters in a single word while preserving the original letter case.
     *
     * Non-letter characters remain in their original positions.
     * (I was thinking about what to do with numbers, but the task says to reverse only letters.)
     *
     * @param string $word The word to reverse
     * @return string The word with letters reversed
     */
    private function processWord(string $word): string
    {
        if ($word === '') {
            return '';
        }

        $chars = mb_str_split($word);
        $letters = [];

        foreach ($chars as $char) {
            if ($this->isLetter($char)) {
                $letters[] = $char;
            }
        }

        $letters = array_reverse($letters);
        $index = 0;

        foreach ($chars as $i => $char) {
            if ($this->isLetter($char)) {
                $newChar = $letters[$index++];
                $chars[$i] = $this->isUpper($char)
                    ? mb_strtoupper($newChar)
                    : mb_strtolower($newChar);
            }
        }

        return implode('', $chars);
    }

    /**
     * Determine whether a character is a letter.
     *
     * @param string $char Single character to check
     * @return bool True if the character is a letter, false otherwise
     */
    private function isLetter(string $char): bool
    {
        return mb_strtolower($char) !== mb_strtoupper($char);
    }

    /**
     * Determine whether a character is uppercase.
     *
     * @param string $char Single character to check
     * @return bool True if the character is uppercase, false otherwise
     */
    private function isUpper(string $char): bool
    {
        return $char === mb_strtoupper($char);
    }
}
