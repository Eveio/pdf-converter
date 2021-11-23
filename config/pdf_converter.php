<?php

return [
    'driver' => env('PDF_CONVERTER_DRIVER', 'dompdf'),
    'pdfcrowd' => [
        'username' => env('PDFCROWD_USERNAME'),
        'api_key' => env('PDFCROWD_API_KEY'),
    ],
];
