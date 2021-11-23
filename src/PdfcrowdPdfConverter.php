<?php

namespace Eve\PdfConverter;

use Eve\PdfConverter\Exceptions\UnsupportedConfigurationException;
use Illuminate\Http\File;
use Pdfcrowd\HtmlToPdfClient;

/**
 * PDF converter using the (paid) Pdfcrowd service.
 */
class PdfcrowdPdfConverter extends AbstractPdfConverter
{
    public HtmlToPdfClient $client;

    public function __construct(?HtmlToPdfClient $client = null)
    {
        $this->client = $client ?? new HtmlToPdfClient(
            config('pdf_converter.pdfcrowd.username'),
            config('pdf_converter.pdfcrowd.api_key')
        );
    }

    public function convertHtml(string $html, ?string $path = null): File
    {
        $path ??= self::getRandomPath();
        $this->client->convertStringToFile($html, $path);

        return new File($path);
    }

    public function configure(string|array $key, ...$values): void
    {
        if (is_array($key)) {
            foreach ($key as $k => $v) {
                $this->configure($k, $v);
            }

            return;
        }

        $methodName = static::configureKeyToMethodName($key);

        if (is_callable([$this->client, $methodName])) {
            $this->client->$methodName(...$values);
        } else {
            throw UnsupportedConfigurationException::make($key, 'pdfcrowd');
        }
    }

    private static function configureKeyToMethodName(string $key): string
    {
        return 'set' . $key;
    }
}
