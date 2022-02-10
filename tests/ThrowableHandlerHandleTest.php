<?php
/**
 * This file is part of Swow-Cloud/Job
 * @license  https://github.com/serendipity-swow/serendipity-job/blob/master/LICENSE
 */

declare(strict_types=1);

namespace Chevere\Tests\ThrowableHandler;

use ErrorException;
use PHPUnit\Framework\TestCase;
use function Chevere\ThrowableHandler\errorsAsExceptions;

/**
 * @internal
 * @coversNothing
 */
final class ThrowableHandlerHandleTest extends TestCase
{
    public function testError(): void
    {
        $this->expectException(ErrorException::class);
        errorsAsExceptions(1, 'Error', __FILE__, __LINE__);
    }
}
