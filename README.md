# eve/pdf-converter

A Laravel package to help convert HTML to PDF. Supports multiple drivers.

## Requirements and Installation

eve/pdf-converter requires Laravel 8.x and PHP 8.x. You can install the package via Composer:

```bash
composer require eve/pdf-converter
```

Next, publish the config file: 

```bash
php artisan vendor:publish --provider="Eve\PdfConverter\ServiceProvider"
```

A `pdf_converter.php` file will be copied into your application's `config` folder.

## Usage

eve/pdf-converter supports 4 drivers, which can be configured in `.env` with the `PDF_CONVERTER_DRIVER` key:

* `dompdf`: The default. Uses [laravel-dompdf](https://github.com/barryvdh/laravel-dompdf) under the hood. 
* `mock`: Always returns a fixture PDF file. Doesn't do any actual conversion.
* `log`: Logs the input HTML and the output path using Laravel's logger. Doesn't do any actual conversion.
* `pdfcrowd`: Uses the commercial [Pdfcrowd](https://pdfcrowd.com/) service. You'll have to set the `PDFCROWD_USERNAME` and `PDFCROWD_API_KEY` as well for this driver to work.

Of these drivers, `mock` and `log` are meant for development and/or testing purposes. `dompdf` can be used for production but will most likely require some heavy configuration, when `pdfcrowd` should be the best choice if you're willing to spend some bucks per month.

> As eve/pdf-converter is developed first and foremost for eve's internal use, we don't have plans to add more drivers ourselves. PRs are welcome, though. 

Once everything is set, the package is dead-boring. You can use either dependency injection or the facade (or both, depending on how silly you want your codebase to look).

### Dependency Injection

Inject `Eve\PdfConverter\PdfConverterInterface` and use it:

```php
public function __construct(private \Eve\PdfConverter\PdfConverterInterface $converter) 
{
    $this->converter->configure('key', 'value');
    
    // returns an \Illuminate\Http\File instance
    $this->converter->convertHtml('<p>Hello World</p>', '/path/to/output/file.pdf');
}
```

### Facade

If you're a fan of [Facades](https://laravel.com/docs/8.x/facades) for whatever reason, eve/pdf-converter provides the `\Eve\PdfConverter\Facades\PdfConverter` facade. This facade is even aliased to `\PdfConverter` for your convenience.

```php
public function generateInvoice(): void
{
    \PdfConverter::configure('key', 'value');
    \PdfConverter::convertHtml('<p>Free of charge</p>', '/my/invoice.pdf');
}
```

## PDF Conversion Configuration

If you've been paying notice, the PDF conversion output can be tweaked via the `configure` method:

```php
$converter->configure(array|string $key, ...$values);
```

Now, the configuration options for the PDF conversion vary from driver to driver. Specifically:

* For `log` and `mock` drivers, the configurations are completely ignored.
* For `dompdf`, refer to the [available options](https://github.com/barryvdh/laravel-dompdf#using) supported by laravel-dompdf itself.
* For `pdfcrowd`, refer to the [official API reference](https://pdfcrowd.com/doc/api/html-to-pdf/php/). Look for the `setX()` functions. You can then use `X` as the `$key` argument for `configure()` method and whatever `setX()` takes as the `$values`. For example:

  | Pdfcrowd's API | eve/pdf-converter counterpart |
  |---------------------|-------------------------------|
  | `setPageSize('a4')` | `configure('PageSize', 'a4')` |
  | `setFooterHeight('30mm')` | `configure('FooterHeight', '30mm')` |
  | `setHttpAuth('hey', 'secret')` | `configure('HttpAuth', 'hey', 'secret')` | 

## License

MIT.
