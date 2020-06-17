<?php

/**
 * Файл из репозитория MikBill-Sberbank-EPS-PHP-API
 * @link https://github.com/itpanda-llc
 */

namespace Panda\MikBill\Sberbank\EPSAPI;

/**
 * Class Action
 * @package Panda\MikBill\Sberbank\EPSAPI
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
