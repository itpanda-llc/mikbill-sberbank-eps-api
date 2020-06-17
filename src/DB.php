<?php

/**
 * Файл из репозитория MikBill-Sberbank-EPS-PHP-API
 * @link https://github.com/itpanda-llc
 */

namespace Panda\MikBill\Sberbank\EPSAPI;

use Panda\MikBill\Sberbank\EPSAPI\Exception\DebugException;

/**
 * Class DB
 * @package Panda\MikBill\Sberbank\EPSAPI
 * Соединение с БД
 */
class DB
{
    /**
     * @var \PDO Обработчик запросов к БД
     */
    private static $dbh;

    /**
     * @return \PDO Обработчик запросов к БД
     */
    public static function connect(): \PDO
    {
        if (!isset(self::$dbh)) {
            $dsn = sprintf("mysql:host=%s;dbname=%s;charset=utf8",
                Config::get()->parameters->mysql->host,
                Config::get()->parameters->mysql->dbname);

            try {
                self::$dbh = new \PDO($dsn,
                    Config::get()->parameters->mysql->username,
                    Config::get()->parameters->mysql->password,
                    [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
            } catch (\PDOException $e) {
                throw new DebugException($e->getMessage());
            }
        }

        return self::$dbh;
    }
}
