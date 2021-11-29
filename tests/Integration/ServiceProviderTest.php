<?php

namespace Eve\PdfConverter\Tests\Integration;

use Eve\PdfConverter\DomPdfPdfConverter;
use Eve\PdfConverter\Exceptions\UnsupportedDriverException;
use Eve\PdfConverter\LogPdfConverter;
use Eve\PdfConverter\MockPdfConverter;
use Eve\PdfConverter\PdfConverterInterface;
use Eve\PdfConverter\PdfcrowdPdfConverter;
use Eve\PdfConverter\ServiceProvider;
use Orchestra\Testbench\TestCase;

class ServiceProviderTest extends TestCase
{
    /** @return array<mixed> */
    public function provideBindingData(): array
    {
        return [
            ['dompdf', DomPdfPdfConverter::class],
            ['mock', MockPdfConverter::class],
            ['log', LogPdfConverter::class],
            ['pdfcrowd', PdfcrowdPdfConverter::class],
        ];
    }

    /** @dataProvider provideBindingData */
    public function testBindingService(string $driver, string $instanceClass): void
    {
        config(['pdf_converter.driver' => $driver]);
        (new ServiceProvider($this->app))->register();

        self::assertInstanceOf($instanceClass, $this->app->get(PdfConverterInterface::class));
    }

    public function testUnsupportedDriver(): void
    {
        self::expectException(UnsupportedDriverException::class);

        config(['pdf_converter.driver' => '__UNSUPPORTED__']);
        (new ServiceProvider($this->app))->register();
    }
}
