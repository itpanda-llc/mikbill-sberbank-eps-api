<?php

/**
 * Файл из репозитория MikBill-Sberbank-EPS-API
 * @link https://github.com/itpanda-llc/mikbill-sberbank-eps-api
 */

namespace Panda\MikBill\Sberbank\EpsApi;

/**
 * Class Holder
 * @package Panda\MikBill\Sberbank\EpsApi
 * Наименования параметров (SQL-запросы)
 */
class Holder
{
    /**
     * Аккаунт
     */
    public const ACCOUNT = ':account';

    /**
     * Наименование сервиса
     */
    public const SERVICE_NAME = ':serviceName';

    /**
     * Номер категории платежа
     */
    public const CATEGORY_ID = ':categoryId';

    /**
     * Номер категории платежа
     */
    public const CATEGORY_NAME = ':categoryId';

    /**
     * Размер платежа
     */
    public const AMOUNT = ':amount';

    /**
     * Номер платежа
     */
    public const PAY_ID = ':payId';

    /**
     * Комментарий платежа
     */
    public const PAYMENT_COMMENT = ':paymentComment';
}
