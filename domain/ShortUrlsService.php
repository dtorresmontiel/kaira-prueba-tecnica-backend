<?php

namespace Domain;

use Domain\ShortUrlsServiceException;

interface ShortUrlsService
{
    /**
     * @throws ShortUrlsServiceException
     */
    public function shortUrl(string $url): string;
}
