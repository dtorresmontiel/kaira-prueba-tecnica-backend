<?php

namespace Infrastructure\Providers;

use Illuminate\Support\Facades\Http;

use Domain\ShortUrlsService;
use Domain\ShortUrlsServiceException;

class ShortUrlsTinyUrlService implements ShortUrlsService
{
    const ENDPOINT = 'https://tinyurl.com/api-create.php';

    /**
     * @throws ShortUrlsServiceException
     */
    public function shortUrl(string $url): string
    {
        $response = Http::get(self::ENDPOINT, ['url' => $url]);
        if (!$response->ok() || !$response->successful()) {
            throw new ShortUrlsServiceException($response->reason(), $response->status());
        }
        return $response->body();
    }
}
