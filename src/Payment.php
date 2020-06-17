<?php

/**
 * Файл из репозитория MikBill-Sberbank-EPS-PHP-API
 * @link https://github.com/itpanda-llc
 */

namespace Panda\MikBill\Sberbank\EPSAPI;

/**
 * Class Payment
 * @package Panda\MikBill\Sberbank\EPSAPI
 * Параметры платежа
 */
class Payment
{
    /**
     * Наименьший размер
     */
    public const MIN_AMOUNT = 20;

    /**
     * Наибольший размер
     */
    public const MAX_AMOUNT = 10000;

    /**
     * Комментарий
     */
    public const COMMENT = 'платеж Сбербанк';
}
