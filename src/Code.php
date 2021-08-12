<?php

/**
 * Файл из репозитория MikBill-Sberbank-EPS-API
 * @link https://github.com/itpanda-llc/mikbill-sberbank-eps-api
 */

namespace Panda\MikBill\Sberbank\EpsApi;

/**
 * Class Code
 * @package Panda\MikBill\Sberbank\EpsApi
 * Код ответа
 */
class Code
{
    /**
     * Успешное завершение операции
     */
    public const DEFAULT = 0;

    /**
     * Временная ошибка
     */
    public const TEMP_ERROR = 1;

    /**
     * Неизвестный тип запроса
     */
    public const ACTION_ERROR = 2;

    /**
     * Аккаунт не найден
     */
    public const SEARCH_ACCOUNT_ERROR = 3;

    /**
     * Неправильное значение идентификатора плательщика
     */
    public const ACCOUNT_ERROR = 4;

    /**
     * Неправильное значение идентификатора транзакции
     */
    public const PAY_ID_ERROR = 6;

    /**
     * Дублирование транзакции
     */
    public const DUPLICATE_PAY_ERROR = 8;

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
    public const INTERNAL_ERROR = 300;
}
