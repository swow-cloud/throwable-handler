<?php
/**
 * This file is part of Swow-Cloud/Job
 * @license  https://github.com/serendipity-swow/serendipity-job/blob/master/LICENSE
 */

declare(strict_types=1);

namespace Chevere\ThrowableHandler\Formats;

use Chevere\Trace\Interfaces\TraceDocumentInterface;
use Chevere\VarDump\Formats\VarDumpConsoleFormat;
use Chevere\VarDump\Interfaces\VarDumpFormatInterface;
use Colors\Color;

final class ThrowableHandlerConsoleFormat extends ThrowableHandlerFormat
{
    public function getVarDumpFormat(): VarDumpFormatInterface
    {
        return new VarDumpConsoleFormat();
    }

    public function getItemTemplate(): string
    {
        return $this->wrapSectionTitle(
            '#' . TraceDocumentInterface::TAG_ENTRY_POS
        )
            . ' '
            . TraceDocumentInterface::TAG_ENTRY_FILE_LINE
            . "\n"
            . TraceDocumentInterface::TAG_ENTRY_CLASS
            . TraceDocumentInterface::TAG_ENTRY_TYPE
            . TraceDocumentInterface::TAG_ENTRY_FUNCTION;
    }

    public function getHr(): string
    {
        return (string) (new Color(str_repeat('-', 60)))->blue();
    }

    public function wrapLink(string $value): string
    {
        return (string) (new Color($value))->underline()->fg('blue');
    }

    public function wrapSectionTitle(string $value): string
    {
        return (string) (new Color($value))->green();
    }
}
