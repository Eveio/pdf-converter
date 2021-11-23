<?php

namespace Eve\PdfConverter\Tests\Unit;

use Eve\PdfConverter\LogPdfConverter;
use Illuminate\Log\LogManager;
use Mockery;
use Mockery\LegacyMockInterface;
use Mockery\MockInterface;
use Orchestra\Testbench\TestCase;

class LogPdfConverterTest extends TestCase
{
    private LogManager|MockInterface|LegacyMockInterface $log;
    private LogPdfConverter $converter;

    protected function setUp(): void
    {
        parent::setUp();

        $this->log = Mockery::mock(LogManager::class);
        $this->converter = new LogPdfConverter($this->log);
    }

    public function testConvertHtml(): void
    {
        $path = sprintf('%s/%s.pdf', sys_get_temp_dir(), uuid());
        $this->log->shouldReceive('debug')
            ->with(sprintf('Generated a PDF file at %s from this HTML:%s<p>Hello World</p>', $path, PHP_EOL));

        $this->converter->convertHtml('<p>Hello World</p>', $path);
    }
}
