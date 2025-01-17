<?php
/**
 * This file is part of Swow-Cloud/Job
 * @license  https://github.com/serendipity-swow/serendipity-job/blob/master/LICENSE
 */

declare(strict_types=1);

namespace Chevere\ThrowableHandler\Formats;

use Chevere\Trace\Interfaces\TraceDocumentInterface;
use Chevere\VarDump\Formats\VarDumpHtmlFormat;
use Chevere\VarDump\Interfaces\VarDumpFormatInterface;

final class ThrowableHandlerHtmlFormat extends ThrowableHandlerFormat
{
    public function getVarDumpFormat(): VarDumpFormatInterface
    {
        return new VarDumpHtmlFormat();
    }

    public function getItemTemplate(): string
    {
        return '<div class="pre pre--stack-entry ' .
            TraceDocumentInterface::TAG_ENTRY_CSS_EVEN_CLASS . '">#' .
            TraceDocumentInterface::TAG_ENTRY_POS . ' ' .
            TraceDocumentInterface::TAG_ENTRY_FILE_LINE . "\n" .
            TraceDocumentInterface::TAG_ENTRY_CLASS .
            TraceDocumentInterface::TAG_ENTRY_TYPE .
            TraceDocumentInterface::TAG_ENTRY_FUNCTION .
            '</div>';
    }

    public function getHr(): string
    {
        return '<div class="hr"><span>'
            . str_repeat('-', 60)
            . '</span></div>';
    }

    public function getLineBreak(): string
    {
        return "\n<br>\n";
    }

    public function wrapHidden(string $value): string
    {
        return '<span class="hide">' . $value . '</span>';
    }

    public function wrapSectionTitle(string $value): string
    {
        return '<div class="title">'
            . str_replace('# ', $this->wrapHidden('#&nbsp;'), $value)
            . '</div>';
    }

    public function wrapTitle(string $value): string
    {
        return '<div class="title title--scream">' . $value . '</div>';
    }
}
