<?php

namespace Eve\PdfConverter;

use Illuminate\Http\File;

/**
 * A mock PDF converter.
 * Always returns a fixed mock PDF file regardless of the input HTML and configuration.
 * Suitable for testing environments.
 */
class MockPdfConverter extends AbstractPdfConverter
{
    public function convertHtml(string $html, ?string $path = null): File
    {
        $path ??= self::getRandomPath();
        copy(__DIR__ . '/../storage/mock.pdf', $path);

        return new File($path);
    }
}
