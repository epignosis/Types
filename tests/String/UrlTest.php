<?php

namespace Epignosis\Types\Tests\String;

use Epignosis\Types\String\Url;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class UrlTest extends TestCase
{
    public function test_CanBeCreatedByUrl(): void
    {
        $url = new Url('https://www.example.com');

        $this->assertEquals('https://www.example.com', $url->getValue());
    }

    public function test_UrlIsTrimmed(): void
    {
        $url = new Url(' https://www.example.com ');

        $this->assertEquals('https://www.example.com', $url->getValue());
    }

    public function test_CanBeCreatedByUrlWithTrailingSlash(): void
    {
        $url = new Url('https://www.example.com/');

        $this->assertEquals('https://www.example.com/', $url->getValue());
    }

    public function test_CanBeCreatedByUrlWithQuery(): void
    {
        $url = new Url('https://www.example.com/?query=1');

        $this->assertEquals('https://www.example.com/?query=1', $url->getValue());
    }

    public function test_CanBeCreatedByUrlWithFragment(): void
    {
        $url = new Url('https://www.example.com/#fragment');

        $this->assertEquals('https://www.example.com/#fragment', $url->getValue());
    }

    public function test_CanBeCreatedByUrlWithQueryAndFragment(): void
    {
        $url = new Url('https://www.example.com/?query=1#fragment');

        $this->assertEquals('https://www.example.com/?query=1#fragment', $url->getValue());
    }

    public function test_CanBeCreatedByUrlWithPort(): void
    {
        $url = new Url('https://www.example.com:8080');

        $this->assertEquals('https://www.example.com:8080', $url->getValue());
    }

    public function test_CannotBeCreatedByInvalidUrl(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Url('www.example.com');
    }
}
