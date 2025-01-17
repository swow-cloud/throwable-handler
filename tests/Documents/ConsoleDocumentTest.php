<?php
/**
 * This file is part of Swow-Cloud/Job
 * @license  https://github.com/serendipity-swow/serendipity-job/blob/master/LICENSE
 */

declare(strict_types=1);

namespace Chevere\Tests\ThrowableHandler\Documents;

use Chevere\ThrowableHandler\Documents\ThrowableHandlerConsoleDocument;
use Chevere\ThrowableHandler\Documents\ThrowableHandlerPlainDocument;
use Chevere\ThrowableHandler\Formats\ThrowableHandlerConsoleFormat;
use Chevere\ThrowableHandler\ThrowableHandler;
use Chevere\ThrowableHandler\ThrowableRead;
use Colors\Color;
use Exception;
use LogicException;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class ConsoleDocumentTest extends TestCase
{
    public function testConstruct(): void
    {
        $handler = new ThrowableHandler(new ThrowableRead(
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
        $document = new ThrowableHandlerConsoleDocument($handler);
        $this->assertSame(
            (new Color())->isSupported()
                ? '[31m[1m%title%[0m[0m in [34m[4m%fileLine%[0m[0m'
                : '%title% in %fileLine%',
            $document->getSectionTitle()
        );
        $this->assertInstanceOf(
            ThrowableHandlerConsoleFormat::class,
            $document->getDocumentFormat()
        );
        $sectionTitle = $document->getSectionTitle();
        $plainDocument = new ThrowableHandlerPlainDocument($handler);
        $this->assertTrue(
            strlen($sectionTitle) > $plainDocument->getSectionTitle()
        );
        $document->__toString();
    }
}
