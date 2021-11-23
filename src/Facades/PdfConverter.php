<?php

namespace Eve\PdfConverter\Facades;

use Eve\PdfConverter\PdfConverterInterface;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Facade;

/**
 * @method static File convertHtml(string $html, ?string $path = null)
 * @method static void configure(array|string $key, ...$value)
 */
class PdfConverter extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return PdfConverterInterface::class;
    }
}
