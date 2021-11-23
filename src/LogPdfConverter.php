<?php

namespace Eve\PdfConverter;

use Illuminate\Http\File;
use Illuminate\Log\LogManager;

/**
 * A fake PDF converter that writes the input HTML and the output path into the application log instead of
 * doing any actual conversion.
 */
class LogPdfConverter extends AbstractPdfConverter
{
    public function __construct(private LogManager $log)
    {
    }

    public function convertHtml(string $html, ?string $path = null): File
    {
        // We create an empty file here still, so that functions that depend on this file (e.g., uploading) won't fail.
        $path ??= self::getRandomPath();
        touch($path);

        $this->log->debug(sprintf('Generated a PDF file at %s from this HTML:%s%s', $path, PHP_EOL, $html));

        return new File($path);
    }
}
