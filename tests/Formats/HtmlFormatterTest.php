<?php
/**
 * This file is part of Swow-Cloud/Job
 * @license  https://github.com/serendipity-swow/serendipity-job/blob/master/LICENSE
 */

declare(strict_types=1);

namespace Chevere\Tests\ThrowableHandler\Formats;

use Chevere\ThrowableHandler\Formats\ThrowableHandlerHtmlFormat;
use Chevere\ThrowableHandler\Formats\ThrowableHandlerPlainFormat;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class HtmlFormatterTest extends TestCase
{
    public function testAgainstPlain(): void
    {
        $plainFormat = new ThrowableHandlerPlainFormat();
        $htmlFormat = new ThrowableHandlerHtmlFormat();
        $array = [
            'getItemTemplate' => [],
            'getHr' => [],
            'getLineBreak' => [],
            'wrapLink' => ['value'],
            'wrapHidden' => ['value'],
            'wrapSectionTitle' => ['value'],
            'wrapTitle' => ['value'],
        ];
        foreach ($array as $methodName => $args) {
            $plain = $plainFormat->{$methodName}(...$args);
            $html = $htmlFormat->{$methodName}(...$args);
            $this->assertSame($plain, strip_tags($html));
        }
    }

    public function testFormatting(): void
    {
        $htmlFormat = new ThrowableHandlerHtmlFormat();
        $array = [
            'getItemTemplate' => [
                [],
                '<div class="pre pre--stack-entry %cssEvenClass%">#%pos% %fileLine%' . "\n" . '%class%%type%%function%</div>',
            ],
            'getHr' => [
                [],
                '<div class="hr"><span>' . str_repeat('-', 60) . '</span></div>',
            ],
            'getLineBreak' => [
                [],
                "\n<br>\n",
            ],
            'wrapLink' => [
                ['value'],
                'value',
            ],
            'wrapHidden' => [
                ['value'],
                '<span class="hide">value</span>',
            ],
            'wrapSectionTitle' => [
                ['value'],
                '<div class="title">value</div>',
            ],
            'wrapSectionTitle' => [
                ['# value'],
                '<div class="title"><span class="hide">#&nbsp;</span>value</div>',
            ],
            'wrapTitle' => [
                ['value'],
                '<div class="title title--scream">value</div>',
            ],
        ];
        foreach ($array as $methodName => $aux) {
            $args = $aux[0];
            $expected = $aux[1];
            $html = $htmlFormat->{$methodName}(...$args);
            $this->assertSame($expected, $html);
        }
    }
}
