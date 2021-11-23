<?php

namespace Eve\PdfConverter\Exceptions;

use RuntimeException;

class UnsupportedDriverException extends RuntimeException
{
    public static function make(string $driver): self
    {
        return new static('Unsupported driver: ' . $driver);
    }
}
