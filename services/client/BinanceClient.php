<?php

namespace app\services\client;

use app\core\Config;
use JetBrains\PhpStorm\ArrayShape;
use JsonException;
use RuntimeException;

class BinanceClient extends BaseClient
{

    protected const LINK = 'api/v3/ticker/price';

    public static function getCurrencyRate(): array
    {
        $response = self::get(Config::get('BINANCE_DOMAIN') . self::LINK, self::getHeader());
        try {
            return json_decode($response, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $exception) {
            throw new RuntimeException('Ошибка:', $exception);
        }
    }

    #[ArrayShape(['query' => "string[]"])]
    public static function getHeader(): array
    {
        return [
            'query' => [
                'symbols' => '["BTCUSDT","BNBUSDT","ETHUSDT"]'
            ],
        ];
    }
}
