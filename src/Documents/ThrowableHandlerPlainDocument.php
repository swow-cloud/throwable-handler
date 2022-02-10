<?php
/**
 * This file is part of Swow-Cloud/Job
 * @license  https://github.com/serendipity-swow/serendipity-job/blob/master/LICENSE
 */

declare(strict_types=1);

namespace Chevere\ThrowableHandler\Documents;

use Chevere\ThrowableHandler\Formats\ThrowableHandlerPlainFormat;
use Chevere\VarDump\Interfaces\VarDumpDocumentFormatInterface;

final class ThrowableHandlerPlainDocument extends ThrowableHandlerDocument
{
    public function getDocumentFormat(): VarDumpDocumentFormatInterface
    {
        return new ThrowableHandlerPlainFormat();
    }
}
