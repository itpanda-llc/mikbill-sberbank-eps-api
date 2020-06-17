<?php

/**
 * Файл из репозитория MikBill-Sberbank-EPS-PHP-API
 * @link https://github.com/itpanda-llc
 */

namespace Panda\MikBill\Sberbank\EPSAPI;

use Panda\MikBill\Sberbank\EPSAPI\Exception\DebugException;

/**
 * Class Response
 * @package Panda\MikBill\Sberbank\EPSAPI
 * Формирование ответа
 */
class Response
{
    /**
     * @param int $code Код
     * @param string $message Сообщение
     * @return string XML-контент
     */
    public static function getError(int $code,
                                    string $message): string
    {
        $sxe = self::getXMLElement();

        $sxe->addChild(Field::CODE, (string) $code);
        $sxe->addChild(Field::MESSAGE, $message);

        return $sxe->asXML();
    }

    /**
     * @param array $account Аккаунт
     * @return string XML-контент
     */
    public static function getAccount(array $account): string
    {
        $sxe = self::getXMLElement();

        $sxe->addChild(Field::FIO, $account[Field::FIO]);
        $sxe->addChild(Field::ADDRESS, $account[Field::ADDRESS]);
        $sxe->addChild(Field::BALANCE, $account[Field::BALANCE]);
        $sxe->addChild(Field::INFO, $account[Field::INFO]);
        $sxe->addChild(Field::CODE, (string) Code::DEFAULT);
        $sxe->addChild(Field::MESSAGE, Message::ACCOUNT_OK);

        return $sxe->asXML();
    }

    /**
     * @param array $payment Платеж
     * @param int|null $code Код
     * @param string|null $message Сообщение
     * @return string XML-контент
     */
    public static function getPayment(array $payment,
                                      int $code,
                                      string $message): string
    {
        $sxe = self::getXMLElement();

        $sxe->addChild(Field::REG_DATE, $payment[Field::REG_DATE]);
        //$sxe->addChild(Field::EXT_ID, $payment[Field::EXT_ID]);
        //$sxe->addChild(Field::AMOUNT, $payment[Field::AMOUNT]);
        $sxe->addChild(Field::CODE, (string) $code);
        $sxe->addChild(Field::MESSAGE, $message);

        return $sxe->asXML();
    }

    /**
     * @return \SimpleXMLElement Объект XML-контента
     */
    private static function getXMLElement(): \SimpleXMLElement
    {
        try {
            return new \SimpleXMLElement(
                sprintf("<?xml version=\"1.0\" encoding=\"%s\"?><%s/>",
                    Charset::UTF_8,
                    Field::MAIN));
        } catch (\Exception $e) {
            throw new DebugException($e->getMessage());
        }
    }
}
