<?php

/**
 * Файл из репозитория MikBill-Sberbank-EPS-API
 * @link https://github.com/itpanda-llc/mikbill-sberbank-eps-api
 */

namespace Panda\MikBill\Sberbank\EpsApi;

/**
 * Class Param
 * @package Panda\MikBill\Sberbank\EpsApi
 * Наименование параметров запроса
 */
class Param
{
    /**
     * Тип
     */
    public const ACTION = 'ACTION';

    /**
     * Аккаунт
     */
    public const ACCOUNT = 'ACCOUNT';

    /**
     * Размер платежа
     */
    public const AMOUNT = 'AMOUNT';

    /**
     * Номер платежа
     */
    public const PAY_ID = 'PAY_ID';

    /**
     * Дата платежа
     */
    public const PAY_DATE = 'PAY_DATE';
}
