<?php

/**
 * Файл из репозитория MikBill-Sberbank-EPS-PHP-API
 * @link https://github.com/itpanda-llc
 */

namespace Panda\MikBill\Sberbank\EPSAPI;

/**
 * Class Status
 * @package Panda\MikBill\Sberbank\EPSAPI
 * Заголовки ответов (HTTP-статус)
 */
class Status
{
    /**
     * 200 OK
     */
    public const OK_200 = 'HTTP/1.0 200 OK';

    /**
     * 400 Bad Request
     */
    public const BAD_REQUEST_400 = 'HTTP/1.0 400 Bad Request';

    /**
     * 401 Unauthorized
     */
    public const UNAUTHORIZED_401 = 'HTTP/1.0 401 Unauthorized';

    /**
     * 500 Internal
     */
    public const INTERNAL_500 = 'HTTP/1.0 500 Internal';
}
