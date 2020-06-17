<?php

/**
 * Файл из репозитория MikBill-Sberbank-EPS-PHP-API
 * @link https://github.com/itpanda-llc
 */

namespace Panda\MikBill\Sberbank\EPSAPI;

use Panda\MikBill\Sberbank\EPSAPI\Exception\DebugException;

/**
 * Class Transaction
 * @package Panda\MikBill\Sberbank\EPSAPI
 * Операции с транзакциями в БД
 */
class Transaction
{
    /**
     * Инициализация
     */
    public static function begin(): void
    {
        try {
            DB::connect()->beginTransaction();
        } catch (\PDOException $e) {
            throw new DebugException($e->getMessage());
        }
    }

    /**
     * Фиксация
     */
    public static function commit(): void
    {
        try {
            DB::connect()->commit();
        } catch (\PDOException $e) {
            throw new DebugException($e->getMessage());
        }
    }

    /**
     * Откат
     */
    public static function rollBack(): void
    {
        try {
            DB::connect()->rollBack();
        } catch (\PDOException $e) {
            throw new DebugException($e->getMessage());
        }
    }
}
