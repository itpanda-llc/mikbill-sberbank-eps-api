<?php

define ('CONFIG', '../../app/etc/config.xml');

require_once '../../../../../mikbill/__ext/mikbill-sberbank-eps-php-api/autoload.php';

use Panda\MikBill\Sberbank\EPSAPI\Content;
use Panda\MikBill\Sberbank\EPSAPI\Logic;
use Panda\MikBill\Sberbank\EPSAPI\Status;
use Panda\MikBill\Sberbank\EPSAPI\Response;
use Panda\MikBill\Sberbank\EPSAPI\Code;
use Panda\MikBill\Sberbank\EPSAPI\Exception\DebugException;

header(Content::XML_TYPE);

$logic = new Logic;

try {
    $logic->run();

    header($logic->getStatus());
    print_r($logic->getContent());
} catch (DebugException $e) {
    header(Status::INTERNAL_500);
    print_r(Response::getError(Code::CUSTOM_ERROR,
        $e->getMessage()));
}
