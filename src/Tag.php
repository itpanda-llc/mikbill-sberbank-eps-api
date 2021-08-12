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
class Tag
{
    /**
     * Основное поле / Главный тег
     */
    public const RESPONSE = 'response';

    /**
     * Код
     */
    public const CODE = 'CODE';

    /**
     * Сообщение
     */
    public const MESSAGE = 'MESSAGE';

    /**
     * Клиент
     */
    public const FIO = 'FIO';

    /**
     * Баланс
     */
    public const BALANCE = 'BALANCE';

    /**
     * Адрес
     */
    public const ADDRESS = 'ADDRESS';

    /**
     * Информация
     */
    public const INFO = 'INFO';

    /**
     * Номер платежа
     */
    public const EXT_ID = 'EXT_ID';

    /**
     * Дата регистрации платежа
     */
    public const REG_DATE = 'REG_DATE';

    /**
     * Размер платежа
     */
    public const AMOUNT = 'AMOUNT';
}
