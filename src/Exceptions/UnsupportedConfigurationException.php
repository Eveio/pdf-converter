<?php

namespace Eve\PdfConverter\Exceptions;

use InvalidArgumentException;

class UnsupportedConfigurationException extends InvalidArgumentException
{
    public static function make(string $configurationKey, string $driver): self
    {
        return new static('The configuration key %s is not supported by the %s driver', $configurationKey, $driver);
    }
}
