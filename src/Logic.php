<?php

/**
 * Файл из репозитория MikBill-Sberbank-EPS-PHP-API
 * @link https://github.com/itpanda-llc
 */

namespace Panda\MikBill\Sberbank\EPSAPI;

use Panda\MikBill\Sberbank\EPSAPI\Exception\DebugException;

/**
 * Class Logic
 * @package Panda\MikBill\Sberbank\EPSAPI
 * Проверка запроса и формирование ответа
 */
class Logic
{
    /**
     * @var string|null Логин
     */
    private $login;

    /**
     * @var string|null Пароль
     */
    private $password;

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
    private $status = Status::UNAUTHORIZED_401;

    /**
     * @var string|null Контент
     */
    private $content;

    /**
     * Logic constructor.
     * Подготовка к обработке запроса
     */
	public function __construct()
	{
        $this->login = $_SERVER['PHP_AUTH_USER'] ?? null;
        $this->password = $_SERVER['PHP_AUTH_PW'] ?? null;

        $query = (empty($_GET)) ? $_POST : $_GET;

		$this->action = (!empty($query[Param::ACTION]))
            ? $query[Param::ACTION]
            : null;
		$this->account = (!empty($query[Param::ACCOUNT]))
            ? $query[Param::ACCOUNT]
            : null;
		$this->amount = (!empty($query[Param::AMOUNT]))
            ? $query[Param::AMOUNT]
            : null;
		$this->payId = (!empty($query[Param::PAY_ID]))
            ? $query[Param::PAY_ID]
            : null;
        $this->payDate = (!empty($query[Param::PAY_DATE]))
            ? $query[Param::PAY_DATE]
            : null;
	}

    /**
     * Проверка параметров запроса и формирование контента
     */
    public function run(): void
    {
        if (($this->login !== Auth::LOGIN)
            || ($this->password !== Auth::PASSWORD))
        {
            $this->content = Response::getError(Code::CUSTOM_ERROR,
                Message::AUTH_ERROR);

            return;
        }

        $this->status = Status::BAD_REQUEST_400;

        try {
            $actions = (new \ReflectionClass(Action::class))->getConstants();
        } catch (\ReflectionException $e) {
            throw new DebugException($e->getMessage());
        }

        if (!in_array($this->action, $actions, true)) {
            $this->content = Response::getError(Code::ACTION_ERROR,
                Message::ACTION_ERROR);

            return;
        }

        if (is_null($this->account)) {
            $this->content = Response::getError(Code::ACCOUNT_ID_ERROR,
                Message::ACCOUNT_ID_ERROR);

            return;
        }

        if ($this->action === Action::CHECK) {
            $this->status = Status::OK_200;

            if (!is_null($account = Query::getAccount($this->account))) {
                $this->content = Response::getAccount($account);
            } else {
                $this->content = Response::getError(Code::ACCOUNT_ERROR,
                    Message::ACCOUNT_ERROR);
            }

            return;
        }

        if ($this->action === Action::PAYMENT) {
            if (is_null($this->amount)) {
                $this->content = Response::getError(Code::AMOUNT_ERROR,
                    Message::AMOUNT_ERROR);

                return;
            }

            if (is_null($this->payId)) {
                $this->content = Response::getError(Code::PAY_ID_ERROR,
                    Message::PAY_ID_ERROR);

                return;
            }

            if (is_null($this->payDate)) {
                $this->content = Response::getError(Code::PAY_DATE_ERROR,
                    Message::PAY_DATE_ERROR);

                return;
            }

            if (!is_null($payment = Query::getPayment($this->payId))) {
                $this->status = Status::OK_200;
                $this->content = Response::getPayment($payment,
                    Code::PAY_DUPLICATE_ERROR,
                    Message::PAY_DUPLICATE_ERROR);

                return;
            }

            if ((Payment::MIN_AMOUNT !== 0)
                && ((float) Payment::MIN_AMOUNT > (float) $this->amount))
            {
                $this->content = Response::getError(Code::MIN_AMOUNT_ERROR,
                    Message::MIN_AMOUNT_ERROR);

                return;
            }

            if ((Payment::MAX_AMOUNT !== 0)
                && ((float) Payment::MAX_AMOUNT < (float) $this->amount))
            {
                $this->content = Response::getError(Code::MAX_AMOUNT_ERROR,
                    Message::MAX_AMOUNT_ERROR);

                return;
            }

            if (is_null(Query::getAccount($this->account))) {
                $this->content = Response::getError(Code::ACCOUNT_ERROR,
                    Message::ACCOUNT_ERROR);

                return;
            }

            if ((!Query::checkCategory()) && (!Query::addCategory()))
                throw new DebugException(Message::PAYMENT_ERROR);

            if ((!Query::addPayment($this->account, $this->amount, $this->payId))
                || (!Query::setPayment($this->payId)))
            {
                throw new DebugException(Message::PAYMENT_ERROR);
            }

            if (!is_null($payment = Query::getPayment($this->payId))) {
                $this->status = Status::OK_200;
                $this->content = Response::getPayment($payment,
                    Code::DEFAULT,
                    Message::PAYMENT_OK);

                return;
            }

            throw new DebugException(Message::PAYMENT_ERROR);
        }
    }

    /**
     * @return string Заголовок (HTTP-статус)
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return string Контент
     */
    public function getContent(): string
    {
        return $this->content;
    }
}
