<?php

/**
 * Файл из репозитория MikBill-Sberbank-EPS-PHP-API
 * @link https://github.com/itpanda-llc
 */

namespace Panda\MikBill\Sberbank\EPSAPI;

/**
 * Class Content
 * @package Panda\MikBill\Sberbank\EPSAPI
 * Заголовок ответа (Тип контента)
 */
class Content
{
    /**
     * text/xml; utf-8
     */
    public const XML_TYPE = 'Content-Type: text/xml; charset=' . Charset::UTF_8;
}
