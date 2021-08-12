<?php

/**
 * Файл из репозитория MikBill-Sberbank-EPS-API
 * @link https://github.com/itpanda-llc/mikbill-sberbank-eps-api
 */

declare(strict_types=1);

namespace Panda\MikBill\Sberbank\EpsApi;

/**
 * Class Query
 * @package Panda\MikBill\Sberbank\EpsApi
 * Запросы к БД
 */
class Query
{
    /**
     * @param string $account Аккаунт
     * @return array|null Аккаунт
     */
    public static function getAccount(string $account): ?array
    {
        $sth = Statement::prepare(Sql::GET_ACCOUNT);

        $sth->bindParam(Holder::ACCOUNT, $account);
        $sth->bindParam(Holder::SERVICE_NAME, $_ENV['SERVICE_NAME']);

        Statement::execute($sth);

        return (($result = $sth->fetch(\PDO::FETCH_ASSOC)) !== false)
            ? $result
            : null;
    }

    /**
     * @param string $payId Номер платежа
     * @return array|null Платеж
     */
    public static function getPayment(string $payId): ?array
    {
        $sth = Statement::prepare(Sql::GET_PAYMENT);

        $categoryId = (int) $_ENV['CATEGORY_ID'];

        $sth->bindParam(Holder::PAY_ID, $payId);
        $sth->bindParam(Holder::CATEGORY_ID,
            $categoryId,
            \PDO::PARAM_INT);

        Statement::execute($sth);

        return (($result = $sth->fetch(\PDO::FETCH_ASSOC)) !== false)
            ? $result
            : null;
    }

    /**
     * @return bool Результат проверки наличия категории платежа
     */
    public static function checkCategory(): bool
    {
        $sth = Statement::prepare(Sql::CHECK_CATEGORY);

        $categoryId = (int) $_ENV['CATEGORY_ID'];

        $sth->bindParam(Holder::CATEGORY_ID,
            $categoryId,
            \PDO::PARAM_INT);

        Statement::execute($sth);

        return $sth->rowCount() !== 0;
    }

    /**
     * @return bool Результат добавления категории платежа
     */
    public static function addCategory(): bool
    {
        $sth = Statement::prepare(Sql::ADD_CATEGORY);

        $categoryId = (int) $_ENV['CATEGORY_ID'];

        $sth->bindParam(Holder::CATEGORY_ID,
            $categoryId,
            \PDO::PARAM_INT);
        $sth->bindParam(Holder::CATEGORY_NAME,
            $_ENV['CATEGORY_NAME']);

        Statement::execute($sth);

        return ($sth->rowCount() !== 0);
    }

    /**
     * @param string $account Аккаунт
     * @param string $amount Размер платежа
     * @param string $payId Номер платежа
     * @return bool Результат добавления платежа
     */
    public static function addPayment(string $account,
                                      string $amount,
                                      string $payId): bool
    {
        $sth = Statement::prepare(Sql::ADD_PAYMENT);

        $categoryId = (int) $_ENV['CATEGORY_ID'];

        $sth->bindParam(Holder::PAY_ID, $payId);
        $sth->bindParam(Holder::CATEGORY_ID,
            $categoryId,
            \PDO::PARAM_INT);
        $sth->bindParam(Holder::ACCOUNT, $account);
        $sth->bindParam(Holder::AMOUNT, $amount);
        $sth->bindParam(Holder::PAYMENT_COMMENT,
            $_ENV['PAYMENT_COMMENT']);

        Statement::execute($sth);

        return ($sth->rowCount() !== 0);
    }

    /**
     * @param string $payId Номер платежа
     * @return bool Результат подготовления платежа
     */
    public static function setPayment(string $payId): bool
    {
        $sth = Statement::prepare(Sql::SET_PAYMENT);

        $sth->bindParam(Holder::PAY_ID, $payId);

        Statement::execute($sth);

        return ($sth->rowCount() !== 0);
    }
}
