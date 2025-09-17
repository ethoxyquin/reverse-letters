<?php

declare(strict_types=1);

namespace App;

use PHPUnit\Framework\TestCase;

final class LetterReverserTest extends TestCase
{
    private LetterReverser $reverser;

    protected function setUp(): void
    {
        parent::setUp();
        $this->reverser = new LetterReverser();
    }

    /**
     * @dataProvider simpleWordsProvider
     */
    public function testSimpleWords(string $input, string $expected): void
    {
        $this->assertSame($expected, $this->reverser->reverse($input));
    }

    public static function simpleWordsProvider(): array
    {
        return [
            ['Cat', 'Tac'],
            ['Мышь', 'Ьшым'],
            ['houSe', 'esuOh'],
            ['домИК', 'кимОД'],
            ['elEpHant', 'tnAhPele'],
        ];
    }

    /**
     * @dataProvider punctuationProvider
     */
    public function testWithPunctuation(string $input, string $expected): void
    {
        $this->assertSame($expected, $this->reverser->reverse($input));
    }

    public static function punctuationProvider(): array
    {
        return [
            ['cat,', 'tac,'],
            ['Зима:', 'Амиз:'],
            ["is 'cold' now", "si 'dloc' won"],
            ['это «Так» "просто"', 'отэ «Кат» "отсорп"'],
        ];
    }

    /**
     * @dataProvider splittersProvider
     */
    public function testWithSplitters(string $input, string $expected): void
    {
        $this->assertSame($expected, $this->reverser->reverse($input));
    }

    public static function splittersProvider(): array
    {
        return [
            ['third-part', 'driht-trap'],
            ["can`t", "nac`t"],
            ["don'’t", "nod'’t"],
        ];
    }

    public function testEmptyString(): void
    {
        $this->assertSame('', $this->reverser->reverse(''));
    }

    public function testStringWithOnlyPunctuation(): void
    {
        $this->assertSame('?!', $this->reverser->reverse('?!'));
    }
}
