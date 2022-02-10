<?php
/**
 * This file is part of Swow-Cloud/Job
 * @license  https://github.com/serendipity-swow/serendipity-job/blob/master/LICENSE
 */

declare(strict_types=1);

namespace Chevere\Tests\ThrowableHandler\Documents;

use Chevere\ThrowableHandler\Documents\ThrowableHandlerHtmlDocument;
use Chevere\ThrowableHandler\Documents\ThrowableHandlerPlainDocument;
use Chevere\ThrowableHandler\Formats\ThrowableHandlerHtmlFormat;
use Chevere\ThrowableHandler\Interfaces\ThrowableHandlerInterface;
use Chevere\ThrowableHandler\ThrowableHandler;
use Chevere\ThrowableHandler\ThrowableRead;
use Exception;
use LogicException;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class HtmlDocumentTest extends TestCase
{
    private ThrowableHandlerInterface $exceptionHandler;

    protected function setUp(): void
    {
        $this->exceptionHandler = new ThrowableHandler(new ThrowableRead(
            new LogicException(
                'Ups',
                1000,
                new Exception(
                    'Previous',
                    100,
                    new Exception('Pre-previous', 10)
                )
            )
        ));
    }

    public function testHandlerDebugOn(): void
    {
        $this->exceptionHandler = $this->exceptionHandler->withIsDebug(true);
        $document = new ThrowableHandlerHtmlDocument($this->exceptionHandler);
        $this->assertInstanceOf(ThrowableHandlerHtmlFormat::class, $document->getDocumentFormat());
        $sectionTitle = $document->getSectionTitle();
        $plainDocument = new ThrowableHandlerPlainDocument($this->exceptionHandler);
        $this->assertTrue(strlen($sectionTitle) > $plainDocument->getSectionTitle());
        $string = $document->__toString();
        $this->assertStringContainsString('<html><head><meta charset="utf-8">', $string);
        $this->assertStringContainsString('<main class="main--stack">', $string);
    }

    public function testHandlerDebugOff(): void
    {
        $this->exceptionHandler = $this->exceptionHandler->withIsDebug(false);
        $document = new ThrowableHandlerHtmlDocument($this->exceptionHandler);
        $this->assertInstanceOf(ThrowableHandlerHtmlFormat::class, $document->getDocumentFormat());
        $sectionTitle = $document->getSectionTitle();
        $plainDocument = new ThrowableHandlerPlainDocument($this->exceptionHandler);
        $this->assertTrue(strlen($sectionTitle) > $plainDocument->getSectionTitle());
        $string = $document->__toString();
        $this->assertStringContainsString('<html><head><meta charset="utf-8">', $string);
        $this->assertStringContainsString('Something went wrong', $string);
        $this->assertStringContainsString('Please try again later.', $string);
        $this->assertStringContainsString('<main class="user-select-none"><div>', $string);
        $this->assertStringContainsString('</span> • <span class="user-select-all">', $string);
    }
}
