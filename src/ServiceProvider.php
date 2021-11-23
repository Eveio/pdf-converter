<?php

namespace Eve\PdfConverter;

use Eve\PdfConverter\Exceptions\UnsupportedDriverException;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class ServiceProvider extends IlluminateServiceProvider
{
    protected bool $defer = false;

    public function register(): void
    {
        $this->app->bind(PdfConverterInterface::class, match (config('pdf_converter.driver')) {
            'dompdf' => DomPdfPdfConverter::class,
            'mock' => MockPdfConverter::class,
            'log' => LogPdfConverter::class,
            'pdfcrowd' => PdfcrowdPdfConverter::class,
            default => UnsupportedDriverException::make(config('pdf_converter.driver')),
        });
    }

    public function boot(): void
    {
        $this->publishes([__DIR__ . '/../config/pdf_converter.php' => config_path('pdf_converter.php')], 'config');
    }

    /** @return array<string> */
    public function provides(): array
    {
        return [PdfConverterInterface::class];
    }
}
