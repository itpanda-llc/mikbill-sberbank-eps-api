<?php

/**
 * Файл из репозитория MikBill-Sberbank-EPS-PHP-API
 * @link https://github.com/itpanda-llc
 */

namespace Panda\MikBill\Sberbank\EPSAPI;

/**
 * Class Holder
 * @package Panda\MikBill\Sberbank\EPSAPI
 * Наименования параметров (SQL-запросы)
 */
class Holder
{
    /**
     * Аккаунт
     */
    public const ACCOUNT = ':account';

    /**
     * Размер платежа
     */
    public const AMOUNT = ':amount';

    /**
     * Номер платежа
     */
    public const PAY_ID = ':payId';
}
