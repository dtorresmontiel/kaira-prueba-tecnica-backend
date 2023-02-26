<?php

namespace Domain;

interface ShortUrlsService
{
    public function shortUrl(string $url): string;
}
