<?php
/**
 * This file is part of Swow-Cloud/Job
 * @license  https://github.com/serendipity-swow/serendipity-job/blob/master/LICENSE
 */

declare(strict_types=1);

namespace Chevere\Tests\ThrowableHandler\Formats;

use Chevere\Str\Str;
use Chevere\ThrowableHandler\Formats\ThrowableHandlerConsoleFormat;
use Chevere\ThrowableHandler\Formats\ThrowableHandlerPlainFormat;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class ConsoleFormatterTest extends TestCase
{
    public function testConstruct(): void
    {
        $plainFormatter = new ThrowableHandlerPlainFormat();
        $consoleFormatter = new ThrowableHandlerConsoleFormat();
        $array = [
            'getItemTemplate' => [],
            'getHr' => [],
            'getLineBreak' => [],
            'wrapLink' => ['value'],
            'wrapSectionTitle' => ['value'],
            'wrapTitle' => ['value'],
        ];
        foreach ($array as $methodName => $args) {
            $plain = $plainFormatter->{$methodName}(...$args);
            $console = $consoleFormatter->{$methodName}(...$args);
            $this->assertSame(
                $plain,
                (new Str($console))->withStripANSIColors()->__toString()
            );
        }
    }
}
