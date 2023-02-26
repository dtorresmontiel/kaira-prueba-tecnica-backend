<?php

namespace Tests\Unit\Providers;

use Illuminate\Support\Facades\Http;

use Infrastructure\Providers\ShortUrlsTinyUrlService;
use Domain\ShortUrlsServiceException;

use PHPUnit\Framework\TestCase;

class ShortUrlsTinyUrlServiceTest extends TestCase
{
    /**
     * @var ShortUrlsTinyUrlService
     */
    private $shortUrlsService;

    /**
     * @var string
     */
    private $tinyUrlEndpoint;

    protected function setUp(): void
    {
        parent::setUp();
        $this->shortUrlsService = new ShortUrlsTinyUrlService;
        $this->tinyUrlEndpoint = ShortUrlsTinyUrlService::ENDPOINT;
    }

    public function testShortUrlsServiceReturnsTheShortUrlGeneratedByTinyUrl()
    {
        $longUrl = 'longUrl';
        $expectedShortUrl = 'https://tinyurl.com/ylx5uce';

        Http::fake([
            "{$this->tinyUrlEndpoint}*{$longUrl}" => Http::response($expectedShortUrl),
        ]);

        $shortUrl = $this->shortUrlsService->shortUrl($longUrl);

        $this->assertEquals($expectedShortUrl, $shortUrl);
    }

    public function testShortUrlsServiceThrowsExceptionWhenTinyUrlsFails()
    {
        $this->expectException(ShortUrlsServiceException::class);
        
        $longUrl = "invalidUrl";

        Http::fake([
            "{$this->tinyUrlEndpoint}*{$longUrl}" => Http::response('Error', 400),
        ]);

        $this->shortUrlsService->shortUrl($longUrl);
    }
}
