<?php

/**
 * Файл из репозитория MikBill-Sberbank-EPS-API
 * @link https://github.com/itpanda-llc/mikbill-sberbank-eps-api
 */

namespace Panda\MikBill\Sberbank\EpsApi;

/**
 * Class Action
 * @package Panda\MikBill\Sberbank\EpsApi
 * Типы запросов
 */
class Action
{
    /**
     * Проверка аккаунта
     */
    public const CHECK = 'check';

    /**
     * Проведение платежа
     */
    public const PAYMENT = 'payment';
}
