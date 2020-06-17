<?php

/**
 * Файл из репозитория MikBill-Sberbank-EPS-PHP-API
 * @link https://github.com/itpanda-llc
 */

namespace Panda\MikBill\Sberbank\EPSAPI;

/**
 * Class Code
 * @package Panda\MikBill\Sberbank\EPSAPI
 * Код ответа
 */
class Code
{
    /**
     * Успешное завершение операции
     */
    public const DEFAULT = 0;

    /**
     * Неизвестный тип запроса
     */
    public const ACTION_ERROR = 2;

    /**
     * Аккаунт не найден
     */
    public const ACCOUNT_ERROR = 3;

    /**
     * Неправильное значение идентификатора плательщика
     */
    public const ACCOUNT_ID_ERROR = 4;

    /**
     * Неправильное значение идентификатора транзакции
     */
    public const PAY_ID_ERROR = 6;

    /**
     * Дублирование транзакции
     */
    public const PAY_DUPLICATE_ERROR = 8;

    /**
     * Неправильное значение размера платежа
     */
    public const AMOUNT_ERROR = 9;

    /**
     * Слишком малый размера платежа
     */
    public const MIN_AMOUNT_ERROR = 10;

    /**
     * Слишком большой размера платежа
     */
    public const MAX_AMOUNT_ERROR = 11;

    /**
     * Неправильное значение даты платежа
     */
    public const PAY_DATE_ERROR = 12;

    /**
     * Внутренняя ошибка
     */
    public const CUSTOM_ERROR = 300;
}
