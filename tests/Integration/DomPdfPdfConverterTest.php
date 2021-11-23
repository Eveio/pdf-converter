<?php

namespace Eve\PdfConverter\Tests\Integration;

use Eve\PdfConverter\DomPdfPdfConverter;
use Orchestra\Testbench\TestCase;

class DomPdfPdfConverterTest extends TestCase
{
    private DomPdfPdfConverter $converter;

    protected function setUp(): void
    {
        parent::setUp();

        $this->converter = app(DomPdfPdfConverter::class);
    }

    public function testConvertHtml(): void
    {
        $path = sprintf('%s/%s.pdf', sys_get_temp_dir(), uuid());
        $file = $this->converter->convertHtml('<p>Hello World</p>', $path);

        self::assertSame('application/pdf', $file->getMimeType());

        @unlink($file);
    }
}
