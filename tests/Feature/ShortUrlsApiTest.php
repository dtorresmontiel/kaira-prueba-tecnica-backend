<?php

namespace Tests\Feature;

use Domain\ShortUrlsService;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class ShortUrlsApiTest extends TestCase
{
    use WithFaker;

    /**
     * @var MockObject|ShortUrlsService
     */
    private $shortUrlService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockShortUrlsServiceResponse('https://tinyurl.com/ylx5uce');
    }

    private function mockShortUrlsServiceResponse(string $shortUrl)
    {
        $this->shortUrlService = $this->getMockBuilder(ShortUrlsService::class)
            ->disableOriginalConstructor()->getMock();
        $this->instance(ShortUrlsService::class, $this->shortUrlService);
        $this->shortUrlService->expects($this->any())->method('shortUrl')
            ->willReturn($shortUrl);
    }

    public function testShortUrlFailedIfAuthTokenNotValid()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer '.$this->faker->text(10))
            ->postJson('/api/v1/short-urls', ['url' => $this->faker->url()])
            ->assertStatus(401);
    }

    public function testShortUrlResponseReceived()
    {
        $response = $this->postJson('/api/v1/short-urls', ['url' => $this->faker->url()])
            ->assertStatus(200)
            ->assertJsonStructure(['url']);
            
        $this->assertTrue(self::isValidUrl($response['url']));
    }

    private static function isValidUrl(string $url): bool
    {
        return $url === filter_var($url, FILTER_VALIDATE_URL);
    }
}
