<?php

/**
 * Файл из репозитория MikBill-Sberbank-EPS-PHP-API
 * @link https://github.com/itpanda-llc
 */

namespace Panda\MikBill\Sberbank\EPSAPI;

/**
 * Class Message
 * @package Panda\MikBill\Sberbank\EPSAPI
 * Сообщения ответа
 */
class Message
{
    /**
     * Код: 0
     */
    public const ACCOUNT_OK = 'Аккаунт найден';

    /**
     * Код: 0
     */
    public const PAYMENT_OK = 'Платеж принят';

    /**
     * Код: 2
     */
    public const ACTION_ERROR = 'Неизвестный тип запроса';

    /**
     * Код: 3
     */
    public const ACCOUNT_ERROR = 'Аккаунт не найден';

    /**
     * Код: 4
     */
    public const ACCOUNT_ID_ERROR = 'Неправильное значение идентификатора плательщика';

    /**
     * Код: 6
     */
    public const PAY_ID_ERROR = 'Неправильное значение идентификатора транзакции';

    /**
     * Код: 8
     */
    public const PAY_DUPLICATE_ERROR = 'Дублирование транзакции';

    /**
     * Код: 9
     */
    public const AMOUNT_ERROR = 'Неправильное значение размера платежа';

    /**
     * Код: 10
     */
    public const MIN_AMOUNT_ERROR = 'Слишком малый размера платежа';

    /**
     * Код: 11
     */
    public const MAX_AMOUNT_ERROR = 'Слишком большой размера платежа';

    /**
     * Код: 12
     */
    public const PAY_DATE_ERROR = 'Неправильное значение даты платежа';

    /**
     * Код: 300
     */
    public const AUTH_ERROR = 'Аутентификация не выполнена';

    /**
     * Код: 300
     */
    public const PAYMENT_ERROR = 'Платеж не принят';
}
