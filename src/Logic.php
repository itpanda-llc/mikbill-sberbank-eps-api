<?php

/**
 * Файл из репозитория MikBill-Sberbank-EPS-API
 * @link https://github.com/itpanda-llc/mikbill-sberbank-eps-api
 */

declare(strict_types=1);

namespace Panda\MikBill\Sberbank\EpsApi;

/**
 * Class Logic
 * @package Panda\MikBill\Sberbank\EpsApi
 * Проверка запроса и формирование ответа
 */
class Logic
{
    /**
     * @var string|null Тип запроса
     */
    private $action;

    /**
     * @var string|null Аккаунт
     */
    private $account;

    /**
     * @var string|null Размер платежа
     */
    private $amount;

    /**
     * @var string|null Номер платежа
     */
    private $payId;

    /**
     * @var string|null Дата платежа
     */
    private $payDate;

    /**
     * @var string Заголовок (HTTP-статус)
     */
    public $status = Status::OK_200;

    /**
     * @var string|null Контент
     */
    public $content;

    public function __construct()
    {
        $this->action = $_REQUEST[Param::ACTION] ?? null;
        $this->action = $_REQUEST[Param::ACCOUNT] ?? null;
        $this->action = $_REQUEST[Param::AMOUNT] ?? null;
        $this->action = $_REQUEST[Param::PAY_ID] ?? null;
        $this->action = $_REQUEST[Param::PAY_DATE] ?? null;
    }

    public function run(): void
    {
        if (($_SERVER['PHP_AUTH_USER'] !== $_ENV['AUTH_LOGIN'])
            || ($_SERVER['PHP_AUTH_PW'] !== $_ENV['AUTH_PASSWORD']))
        {
            $this->status = Status::UNAUTHORIZED_401;
            $this->content = Response::getError(Code::INTERNAL_ERROR,
                Message::AUTH_ERROR);

            return;
        }

        foreach (explode(",", $_ENV['NETWORK_LIST']) as $v) {
            if (Network::check($_SERVER['REMOTE_ADDR'], $v)) {
                $this->status = Status::OK_200;
                $this->content = null;

                break;
            }

            $this->status = Status::FORBIDDEN_403;
            $this->content = Response::getError(Code::INTERNAL_ERROR,
                Message::ADDRESS_ERROR);
        }

        if (!is_null($this->content)) return;

        try {
            $actions = (new \ReflectionClass(Action::class))->getConstants();
        } catch (\ReflectionException $e) {
            throw new Exception\DebugException($e->getMessage());
        }

        if (!in_array($this->action, $actions, true)) {
            $this->status = Status::BAD_REQUEST_400;
            $this->content = Response::getError(Code::ACTION_ERROR,
                Message::ACTION_ERROR);

            return;
        }

        if (is_null($this->account)) {
            $this->status = Status::BAD_REQUEST_400;
            $this->content = Response::getError(Code::ACCOUNT_ERROR,
                Message::ACCOUNT_ERROR);

            return;
        }

        if ($this->action === Action::CHECK) {
            $this->content =
                (!is_null($account = Query::getAccount($this->account)))
                    ? Response::getAccount($account)
                    : Response::getError(Code::SEARCH_ACCOUNT_ERROR,
                        Message::SEARCH_ACCOUNT_ERROR);

            return;
        }

        if ($this->action === Action::PAYMENT) {
            if (is_null($this->amount)) {
                $this->status = Status::BAD_REQUEST_400;
                $this->content = Response::getError(Code::AMOUNT_ERROR,
                    Message::AMOUNT_ERROR);

                return;
            }

            if (is_null($this->payId)) {
                $this->status = Status::BAD_REQUEST_400;
                $this->content = Response::getError(Code::PAY_ID_ERROR,
                    Message::PAY_ID_ERROR);

                return;
            }

            if (is_null($this->payDate)) {
                $this->status = Status::BAD_REQUEST_400;
                $this->content = Response::getError(Code::PAY_DATE_ERROR,
                    Message::PAY_DATE_ERROR);

                return;
            }

            if (!is_null($payment = Query::getPayment($this->payId))) {
                $this->content = Response::getPayment($payment,
                    Code::DUPLICATE_PAY_ERROR,
                    Message::DUPLICATE_PAY_ERROR);

                return;
            }

            if (is_null(Query::getAccount($this->account))) {
                $this->status = Status::BAD_REQUEST_400;
                $this->content = Response::getError(Code::SEARCH_ACCOUNT_ERROR,
                    Message::SEARCH_ACCOUNT_ERROR);

                return;
            }

            if (($_ENV['MIN_PAYMENT_AMOUNT'] !== 0)
                && ((float) $_ENV['MIN_PAYMENT_AMOUNT'] > (float) $this->amount))
            {
                $this->status = Status::BAD_REQUEST_400;
                $this->content = Response::getError(Code::MIN_AMOUNT_ERROR,
                    Message::MIN_AMOUNT_ERROR);

                return;
            }

            if (($_ENV['MAX_PAYMENT_AMOUNT'] !== 0)
                && ((float) $_ENV['MAX_PAYMENT_AMOUNT'] < (float) $this->amount))
            {
                $this->status = Status::BAD_REQUEST_400;
                $this->content = Response::getError(Code::MAX_AMOUNT_ERROR,
                    Message::MAX_AMOUNT_ERROR);

                return;
            }

            if ((!Query::checkCategory()) && (!Query::addCategory())) {
                $this->status = Status::INTERNAL_500;
                $this->content = Response::getError(Code::TEMP_ERROR,
                    Message::TEMP_ERROR);

                return;
            }

            Transaction::begin();

            if ((!Query::addPayment($this->account, $this->amount, $this->payId))
                || (!Query::setPayment($this->payId)))
            {
                Transaction::rollBack();

                $this->status = Status::INTERNAL_500;
                $this->content = Response::getError(Code::TEMP_ERROR,
                    Message::TEMP_ERROR);

                return;
            }

            Transaction::commit();

            if (!is_null($payment = Query::getPayment($this->payId))) {
                $this->content = Response::getPayment($payment,
                    Code::DEFAULT,
                    Message::ACCEPT_PAY_OK);

                return;
            }
        }
    }
}
