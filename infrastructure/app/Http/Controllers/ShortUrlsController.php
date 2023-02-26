<?php

namespace Infrastructure\Http\Controllers;

use App\Http\Controllers\Controller;

use Domain\ShortUrlsService;
use Infrastructure\Http\Requests\ShortUrlsRequest;

class ShortUrlsController extends Controller
{
    /**
     * @var ShortUrlsService
     */
    private $shortUrlsService;

    public function __construct(ShortUrlsService $shortUrlsService)
    {
        $this->shortUrlsService = $shortUrlsService;
    }

    public function __invoke(ShortUrlsRequest $request)
    {
        $url = $request->json('url');
        $shortUrl = $this->shortUrlsService->shortUrl($url);
        return response()->json(new ShortUrlsResponse($shortUrl));
    }
}
