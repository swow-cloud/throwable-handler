<?php
/**
 * This file is part of Swow-Cloud/Job
 * @license  https://github.com/serendipity-swow/serendipity-job/blob/master/LICENSE
 */

declare(strict_types=1);

namespace Chevere\ThrowableHandler\Formats;

use Chevere\Trace\Interfaces\TraceDocumentInterface;
use Chevere\VarDump\Interfaces\VarDumpDocumentFormatInterface;
use Chevere\VarDump\Interfaces\VarDumpFormatInterface;

abstract class ThrowableHandlerFormat implements VarDumpDocumentFormatInterface
{
    protected VarDumpFormatInterface $varDumpFormatter;

    final public function __construct()
    {
        $this->varDumpFormatter = $this->getVarDumpFormat();
    }

    final public function varDumpFormat(): VarDumpFormatInterface
    {
        return $this->varDumpFormatter;
    }

    abstract public function getVarDumpFormat(): VarDumpFormatInterface;

    public function getItemTemplate(): string
    {
        return '#' . TraceDocumentInterface::TAG_ENTRY_POS .
            ' ' . TraceDocumentInterface::TAG_ENTRY_FILE_LINE . "\n" .
            TraceDocumentInterface::TAG_ENTRY_CLASS .
            TraceDocumentInterface::TAG_ENTRY_TYPE .
            TraceDocumentInterface::TAG_ENTRY_FUNCTION;
    }

    public function getHr(): string
    {
        return '------------------------------------------------------------';
    }

    public function getLineBreak(): string
    {
        return "\n\n";
    }

    public function wrapLink(string $value): string
    {
        return $value;
    }

    public function wrapHidden(string $value): string
    {
        return $value;
    }

    public function wrapSectionTitle(string $value): string
    {
        return $value;
    }

    public function wrapTitle(string $value): string
    {
        return $value;
    }
}
