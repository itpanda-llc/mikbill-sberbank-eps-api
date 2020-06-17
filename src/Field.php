<?php

/**
 * Файл из репозитория MikBill-Sberbank-EPS-PHP-API
 * @link https://github.com/itpanda-llc
 */

namespace Panda\MikBill\Sberbank\EPSAPI;

/**
 * Class Field
 * @package Panda\MikBill\Sberbank\EPSAPI
 * Наименование полей в ответе
 */
class Field
{
    /**
     * Основное поле / Главный тег
     */
    public const MAIN = 'response';

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
