<?php

/**
 * Файл из репозитория MikBill-Sberbank-EPS-API
 * @link https://github.com/itpanda-llc/mikbill-sberbank-eps-api
 */

declare(strict_types=1);

require_once '/var/mikbill/__ext/vendor/autoload.php';

use Panda\MikBill\Sberbank\EpsApi;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(
    '/var/mikbill/__ext/vendor/itpanda-llc/mikbill-sberbank-eps-api/');

try {
    $dotenv->load();
} catch (\Dotenv\Exception\InvalidPathException $e) {
    header(EpsApi\Status::INTERNAL_500);
    print_r(EpsApi\Response::getError(EpsApi\Code::INTERNAL_ERROR,
        $e->getMessage()));
}

header(sprintf("%s; charset=%s",
    EpsApi\Content::TEXT_XML,
    $_ENV['RESPONSE_CHARSET']));

$logic = new EpsApi\Logic;

try {
    $logic->run();

    header($logic->status);
    print_r($logic->content);
} catch (EpsApi\Exception\SystemException
    | EpsApi\Exception\DebugException $e) {
    header(EpsApi\Status::INTERNAL_500);
    print_r(EpsApi\Response::getError(EpsApi\Code::INTERNAL_ERROR,
        $e->getMessage()));
}
