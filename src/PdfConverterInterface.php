<?php

namespace Eve\PdfConverter;

use Illuminate\Http\File;

interface PdfConverterInterface
{
    public function convertHtml(string $html, ?string $path = null): File;

    public function configure(string|array $key, ...$values): void;
}
