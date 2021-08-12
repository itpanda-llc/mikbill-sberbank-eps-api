<?php

/**
 * Файл из репозитория MikBill-Sberbank-EPS-API
 * @link https://github.com/itpanda-llc/mikbill-sberbank-eps-api
 */

declare(strict_types=1);

namespace Panda\MikBill\Sberbank\EpsApi;

/**
 * Class Response
 * @package Panda\MikBill\Sberbank\EpsApi
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
        $sxe = self::getXmlElement();

        $sxe->addChild(Tag::CODE, (string) $code);
        $sxe->addChild(Tag::MESSAGE, $message);

        return $sxe->asXML();
    }

    /**
     * @param array $account Аккаунт
     * @return string XML-контент
     */
    public static function getAccount(array $account): string
    {
        $sxe = self::getXmlElement();

        $sxe->addChild(Tag::FIO, $account[Field::FIO]);
        $sxe->addChild(Tag::ADDRESS, $account[Field::ADDRESS]);
        $sxe->addChild(Tag::BALANCE, $account[Field::BALANCE]);
        $sxe->addChild(Tag::INFO, $account[Field::INFO]);
        $sxe->addChild(Tag::CODE, (string) Code::DEFAULT);
        $sxe->addChild(Tag::MESSAGE, Message::SEARCH_ACCOUNT_OK);

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
        $sxe = self::getXmlElement();

        $sxe->addChild(Tag::REG_DATE, $payment[Field::REG_DATE]);
        $sxe->addChild(Tag::EXT_ID, $payment[Field::EXT_ID]);
        $sxe->addChild(Tag::AMOUNT, $payment[Field::AMOUNT]);
        $sxe->addChild(Tag::CODE, (string) $code);
        $sxe->addChild(Tag::MESSAGE, $message);

        return $sxe->asXML();
    }

    /**
     * @return \SimpleXMLElement Объект XML-контента
     */
    private static function getXmlElement(): \SimpleXMLElement
    {
        try {
            return new \SimpleXMLElement(
                sprintf("<?xml version=\"1.0\" encoding=\"%s\"?><%s/>",
                    $_ENV['RESPONSE_CHARSET'],
                    Tag::RESPONSE));
        } catch (\Exception $e) {
            throw new Exception\DebugException($e->getMessage());
        }
    }
}
