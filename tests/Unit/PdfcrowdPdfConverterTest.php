<?php

namespace Eve\PdfConverter\Tests\Unit;

use Eve\PdfConverter\PdfcrowdPdfConverter;
use Illuminate\Http\File;
use Mockery;
use Mockery\LegacyMockInterface;
use Mockery\MockInterface;
use Orchestra\Testbench\TestCase;
use Pdfcrowd\HtmlToPdfClient;

class PdfcrowdPdfConverterTest extends TestCase
{
    private PdfcrowdPdfConverter $converter;
    private HtmlToPdfClient|MockInterface|LegacyMockInterface $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = Mockery::mock(HtmlToPdfClient::class);
        $this->converter = new PdfcrowdPdfConverter($this->client);
    }

    public function testConvertHtml(): void
    {
        $path = sprintf('%s/%s.pdf', sys_get_temp_dir(), uuid());
        touch($path);

        $this->client->shouldReceive('convertStringToFile')
            ->with('<p>Hello World</p>', $path)
            ->andReturn(new File($path));

        $file = $this->converter->convertHtml('<p>Hello World</p>', $path);
        self::assertSame($path, $file->getPathname());
    }

    /** @return array<mixed> */
    public function provideConfigureData(): array
    {
        return [
            ['PageSize', 'setPageSize', 'a4'],
            ['FooterHeight', 'setFooterHeight', '30mm'],
            ['HttpAuth', 'setHttpAuth', 'foo', 'bar'],
        ];
    }

    /** @dataProvider provideConfigureData */
    public function testConfigure(string $key, string $calledMethod, ...$values): void
    {
        $this->client->shouldReceive($calledMethod)
            ->with(...$values);

        $this->converter->configure($key, ...$values);
    }
}
