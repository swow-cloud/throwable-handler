<?php
/**
 * This file is part of Swow-Cloud/Job
 * @license  https://github.com/serendipity-swow/serendipity-job/blob/master/LICENSE
 */

declare(strict_types=1);

namespace Chevere\ThrowableHandler\Documents;

use Chevere\ThrowableHandler\Formats\ThrowableHandlerConsoleFormat;
use Chevere\VarDump\Interfaces\VarDumpDocumentFormatInterface;
use Colors\Color;

final class ThrowableHandlerConsoleDocument extends ThrowableHandlerDocument
{
    public function getDocumentFormat(): VarDumpDocumentFormatInterface
    {
        return new ThrowableHandlerConsoleFormat();
    }

    public function getSectionTitle(): string
    {
        return strtr('%t in %f', [
            '%t' => strval((new Color(self::TAG_TITLE))->bold()->red()),
            '%f' => $this->documentFormat->wrapLink(self::TAG_FILE_LINE),
        ]);
    }
}
