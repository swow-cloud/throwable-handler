<?php
/**
 * This file is part of Swow-Cloud/Job
 * @license  https://github.com/serendipity-swow/serendipity-job/blob/master/LICENSE
 */

declare(strict_types=1);

namespace Chevere\Tests\ThrowableHandler;

use Chevere\ThrowableHandler\Formats\ThrowableHandlerPlainFormat;
use Chevere\Trace\TraceDocument;
use Exception;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class ThrowableTraceFormatterTest extends TestCase
{
    private string $hrLine;

    protected function setUp(): void
    {
        $this->hrLine = str_repeat('-', 60);
    }

    public function testRealStackTrace(): void
    {
        $e = new Exception('Message', 100);
        $document = new TraceDocument($e->getTrace(), new ThrowableHandlerPlainFormat());
        $this->assertIsArray($document->toArray());
        $this->assertIsString($document->__toString());
    }

    public function testNullStackTrace(): void
    {
        $trace = [
            0 => [
                'file' => null,
                'line' => null,
                'function' => null,
                'class' => null,
                'type' => null,
                'args' => [false, null],
            ],
        ];
        $document = new TraceDocument(
            $trace,
            new ThrowableHandlerPlainFormat()
        );
        $this->assertSame([
            0 => "#0 \n(boolean false, NULL)",
        ], $document->toArray());
        $this->assertSame(
            $this->hrLine .
            "\n#0 " .
            "\n(boolean false, NULL)" .
            "\n" . $this->hrLine,
            $document->__toString()
        );
    }

    public function testFakeStackTrace(): void
    {
        $file = __FILE__;
        $line = 123;
        $fqn = 'The\\Full\\className';
        $type = '->';
        $method = 'methodName';
        $trace = [
            0 => [
                'file' => $file,
                'line' => $line,
                'function' => $method,
                'class' => $fqn,
                'type' => $type,
                'args' => [],
            ],
            1 => [
                'file' => $file,
                'line' => $line,
                'function' => $method,
                'class' => $fqn,
                'type' => $type,
                'args' => [],
            ],
        ];
        $document = new TraceDocument(
            $trace,
            new ThrowableHandlerPlainFormat()
        );
        $expectEntries = [];
        foreach (array_keys($trace) as $pos) {
            $expect = "#{$pos} {$file}:{$line}\n{$fqn}{$type}{$method}()";
            $expectEntries[] = $expect;
            $this->assertSame(
                $expect,
                $document->toArray()[$pos]
            );
        }
        $expectString = $this->hrLine . "\n" .
            implode("\n" . $this->hrLine . "\n", $expectEntries) . "\n" .
            $this->hrLine;
        $this->assertSame($expectString, $document->__toString());
    }
}
