<?php

namespace Eve\PdfConverter;

abstract class AbstractPdfConverter implements PdfConverterInterface
{
    protected static function getRandomPath(): string
    {
        return sprintf('%s/%s.pdf', sys_get_temp_dir(), uuid());
    }

    public function configure(array|string $key, ...$values): void
    {
        // Noop by default.
    }
}
