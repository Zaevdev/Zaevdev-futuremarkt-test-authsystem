<?php

namespace app\services\client;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use RuntimeException;

class BaseClient
{
    public static function get(string $link, array $header): string
    {
        try {
            $client = new Client();
            $response = $client->get($link, $header);

            return $response->getBody()->getContents();
        } catch (GuzzleException) {
            return 'error';
        }
    }
}
