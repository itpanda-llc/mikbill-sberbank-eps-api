<?php

/**
 * Файл из репозитория MikBill-Sberbank-EPS-API
 * @link https://github.com/itpanda-llc/mikbill-sberbank-eps-api
 */

declare(strict_types=1);

namespace Panda\MikBill\Sberbank\EpsApi;

/**
 * Class Config
 * @package Panda\MikBill\Sberbank\EpsApi
 * Получение конфигурации
 */
class Config
{
    /**
     * @var \SimpleXMLElement Объект конфигурационного файла
     */
    private static $sxe;

    /**
     * @return \SimpleXMLElement Объект конфигурационного файла
     */
    public static function get(): \SimpleXMLElement
    {
        if (!isset(self::$sxe))
            try {
                self::$sxe = new \SimpleXMLElement($_ENV['MIKBILL_CONFIG'],
                    LIBXML_ERR_NONE,
                    true);
            } catch (\Exception $e) {
                throw new Exception\DebugException($e->getMessage());
            }

        return self::$sxe;
    }
}
