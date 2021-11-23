<?php

namespace Eve\PdfConverter\Tests\Integration;

use Eve\PdfConverter\MockPdfConverter;
use Orchestra\Testbench\TestCase;

class MockPdfConverterTest extends TestCase
{
    private MockPdfConverter $converter;

    protected function setUp(): void
    {
        parent::setUp();

        $this->converter = app(MockPdfConverter::class);
    }

    public function testConvertHtml(): void
    {
        $path = sprintf('%s/%s.pdf', sys_get_temp_dir(), uuid());
        $this->converter->convertHtml('<p>Hello World</p>', $path);

        self::assertFileEquals(__DIR__ . '/../../storage/mock.pdf', $path);

        @unlink($path);
    }
}
