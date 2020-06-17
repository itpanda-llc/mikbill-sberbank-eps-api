<?php

/**
 * Файл из репозитория MikBill-Sberbank-EPS-PHP-API
 * @link https://github.com/itpanda-llc
 */

namespace Panda\MikBill\Sberbank\EPSAPI;

/**
 * Class Query
 * @package Panda\MikBill\Sberbank\EPSAPI
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
        $sth = Statement::prepare(SQL::GET_ACCOUNT);

        $sth->bindParam(Holder::ACCOUNT, $account);

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
        $sth = Statement::prepare(SQL::GET_PAYMENT);

        $sth->bindParam(Holder::PAY_ID, $payId);

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
        $sth = Statement::query(SQL::CHECK_CATEGORY);

        return ($sth->rowCount() !== 0) ? true : false;
    }

    /**
     * @return bool Результат добавления категории платежа
     */
    public static function addCategory(): bool
    {
        return (Statement::exec(SQL::ADD_CATEGORY) !== 0)
            ? true
            : false;
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
        Transaction::begin();

        $sth = Statement::prepare(SQL::ADD_PAYMENT);

        $sth->bindParam(Holder::ACCOUNT, $account);
        $sth->bindParam(Holder::AMOUNT, $amount);
        $sth->bindParam(Holder::PAY_ID, $payId);

        Statement::execute($sth);

        if ($sth->rowCount() !== 0) {
            return true;
        } else {
            Transaction::rollBack();

            return false;
        }
    }

    /**
     * @param string $payId Номер платежа
     * @return bool Результат подготовления платежа
     */
    public static function setPayment(string $payId): bool
    {
        $sth = Statement::prepare(SQL::SET_PAYMENT);

        $sth->bindParam(Holder::PAY_ID, $payId);

        Statement::execute($sth);

        if ($sth->rowCount() !== 0) {
            Transaction::commit();

            return true;
        } else {
            Transaction::rollBack();

            return false;
        }
    }
}
