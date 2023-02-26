<?php

namespace Infrastructure\Http\Controllers;

class ShortUrlsResponse implements \JsonSerializable
{
    /**
     * @var string
     */
    private $url;

    public static function factory(string $url)
    {
        return new self($url);
    }

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function jsonSerialize()
    {
        return [
            'url' => $this->url,
        ];
    }
}