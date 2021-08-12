<?php

/**
 * Файл из репозитория MikBill-Sberbank-EPS-API
 * @link https://github.com/itpanda-llc/mikbill-sberbank-eps-api
 */

namespace Panda\MikBill\Sberbank\EpsApi;

/**
 * Class Tag
 * @package Panda\MikBill\Sberbank\EpsApi
 * Наименование полей в ответе
 */
class Field
{
    /**
     * Клиент
     */
    public const FIO = 'fio';

    /**
     * Баланс
     */
    public const BALANCE = 'balance';

    /**
     * Адрес
     */
    public const ADDRESS = 'address';

    /**
     * Информация
     */
    public const INFO = 'info';

    /**
     * Номер платежа
     */
    public const EXT_ID = 'ext_id';

    /**
     * Дата регистрации платежа
     */
    public const REG_DATE = 'reg_date';

    /**
     * Размер платежа
     */
    public const AMOUNT = 'amount';
}
