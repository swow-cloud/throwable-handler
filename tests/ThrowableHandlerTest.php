<?php
/**
 * This file is part of Swow-Cloud/Job
 * @license  https://github.com/serendipity-swow/serendipity-job/blob/master/LICENSE
 */

declare(strict_types=1);

namespace Chevere\Tests\ThrowableHandler;

use Chevere\Message\Message;
use Chevere\Throwable\Exceptions\LogicException;
use Chevere\ThrowableHandler\Interfaces\ThrowableHandlerInterface;
use Chevere\ThrowableHandler\ThrowableHandler;
use Chevere\ThrowableHandler\ThrowableRead;
use DateTimeInterface;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class ThrowableHandlerTest extends TestCase
{
    public function testConstruct(): void
    {
        $handler = $this->getExceptionHandler();
        $this->assertInstanceOf(DateTimeInterface::class, $handler->dateTimeUtc());
        $this->assertInstanceOf(ThrowableRead::class, $handler->throwableRead());
        $this->assertIsString($handler->id());
        $this->assertTrue($handler->isDebug());
    }

    public function testWithDebug(): void
    {
        $handler = $this->getExceptionHandler();
        $handlerWithDebug = $handler->withIsDebug(true);
        $this->assertNotSame($handler, $handlerWithDebug);
        $this->assertTrue(
            $handlerWithDebug->isDebug()
        );
    }

    private function getExceptionHandler(): ThrowableHandlerInterface
    {
        return
            new ThrowableHandler(
                new ThrowableRead(
                    new LogicException(new Message('Ups'), 100)
                )
            );
    }
}
