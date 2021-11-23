<?php

namespace Eve\PdfConverter;

use Barryvdh\DomPDF\PDF as DomPdf;
use Illuminate\Http\File;

/**
 * Basic PDF converter using the DOMPDF library.
 * Likely NOT suitable for production without a lot of customizations and configurations.
 * Most suitable for environments where the quality of the output PDF isn't of utmost importance.
 */
class DomPdfPdfConverter extends AbstractPdfConverter
{
    private array $options = [];

    public function __construct(private DomPdf $pdf)
    {
    }

    public function convertHtml(string $html, ?string $path = null): File
    {
        $path ??= self::getRandomPath();
        $this->pdf->loadHTML($html)->save($path);

        return new File($path);
    }

    public function configure(array|string $key, ...$values): void
    {
        if (is_array($key)) {
            $this->options = array_merge($this->options, $key);
        } else {
            $this->options[$key] = $values[0];
        }

        $this->pdf->setOptions($this->options);
    }
}
