# MikBill-Sberbank-EPS-PHP-API

API для биллинговой системы [АСР "MikBill"](https://mikbill.pro), позволящий осуществлять прием платежей через платежную систему [ПАО "Сбербанк"](https://sberbank.ru) (все каналы, отделения, Сбербанк Онл@йн).

[![GitHub license](https://img.shields.io/badge/license-MIT-blue)](LICENSE)

## Ссылки

* [Разработка](https://github.com/itpanda-llc)
* [О проекте ("АСР MikBill")](https://mikbill.pro)
* [Документация ("АСР MikBill")](https://wiki.mikbill.pro)
* [Сообщество ("АСР MikBill")](https://mikbill.userecho.com)
* [О проекте (ПАО "Сбербанк")](https://sberbank.ru)
* [Типовой протокол Сбербанка_1_v1](%D0%A2%D0%B8%D0%BF%D0%BE%D0%B2%D0%BE%D0%B9%20%D0%BF%D1%80%D0%BE%D1%82%D0%BE%D0%BA%D0%BE%D0%BB%20%D0%A1%D0%B1%D0%B5%D1%80%D0%B1%D0%B0%D0%BD%D0%BA%D0%B0_1_v1.docx)
* [Требования к online интерфейсу клиента Сбербанка_v1](%D0%A2%D1%80%D0%B5%D0%B1%D0%BE%D0%B2%D0%B0%D0%BD%D0%B8%D1%8F%20%D0%BA%20online%20%D0%B8%D0%BD%D1%82%D0%B5%D1%80%D1%84%D0%B5%D0%B9%D1%81%D1%83%20%D0%BA%D0%BB%D0%B8%D0%B5%D0%BD%D1%82%D0%B0%20%D0%A1%D0%B1%D0%B5%D1%80%D0%B1%D0%B0%D0%BD%D0%BA%D0%B0_v1.docx)

## Возможности

* Формирование статуса ответа и контента
* Проверка параметров запроса
* Проверка и вывод информации о лицевом счете и платеже
* Добавление категории платежа
* Проведение платежа и вывод информации о платеже

## Требования

* PHP >= 7.2
* PDO
* SimpleXML

## Установка

```shell script
php composer.phar require "itpanda-llc/mikbill-sberbank-eps-php-api"
```

или

```shell script
git clone https://github.com/itpanda-llc/mikbill-sberbank-eps-php-api
```

## Конфигурация и начало пользования

##### Указание параметров в некоторых файлах

1. Параметры аутентификации - ["src/Auth.php"](src/Auth.php) (информация банка)
2. Параметры услуги - ["src/Service.php"](src/Service.php) (информация банка)
3. Параметры категории платежа - ["src/Category.php"](src/Category.php)

##### Создание индексного файла, например "index.php" (или использование файла из репозитория, с откорректированными указателями на файлы), в требуемом каталоге, для веб-сервера

```php
<?php

/*
 * Актуально для ОС "CentOS".
 * Возможно не изменять указатели на файлы, при условии размещения файла с этим кодом (файла из репозитория)
 * в директории по адресу "/var/www/mikbill/admin/process/имя директории, например, например "sberbank"/",
 * а содержимого репозитория в директории по адресу "/var/mikbill/__ext/mikbill-sberbank-eps-php-api/".
 */

// Определение файла конфигурации АСР "MikBill"
define ('CONFIG', '../../app/etc/config.xml');

// Подключение инструмента
require_once '../../../../../mikbill/__ext/mikbill-sberbank-eps-php-api/autoload.php';

// Импорт составляющих
use Panda\MikBill\Sberbank\EPSAPI\Content;
use Panda\MikBill\Sberbank\EPSAPI\Logic;
use Panda\MikBill\Sberbank\EPSAPI\Status;
use Panda\MikBill\Sberbank\EPSAPI\Response;
use Panda\MikBill\Sberbank\EPSAPI\Exception\DebugException;

// Отправка заголовка (тип контента)
header(Content::TYPE);

// Запуск приложения
$logic = new Logic;

try {
    // Обработка запроса
    $logic->run();

    // Отправка заголовка (HTTP-статус)
    header($logic->getStatus());

    // Вывод контента
    print_r($logic->getContent());
} catch (DebugException $e) {
    // Отправка заголовка (HTTP-статус - "500 Internal")
    header(Status::INTERNAL_500);

    // Вывод контента (сообщение об ошибке)
    print_r(Response::debug($e->getMessage()));
}
```

## Примеры ответов интерфейса

Проверка аккаунта

```xml
<?xml version="1.0" encoding="utf-8"?>
<response>
    <FIO>Ж******* О******* М**************</FIO>
    <ADDRESS>Октябрьская ул, 8/а</ADDRESS>
    <BALANCE>0.00</BALANCE>
    <INFO>
        +7********27 // Домашний интернет // СВ-ИТ0114 // Активен
    </INFO>
    <CODE>0</CODE>
    <MESSAGE>Абонент найден</MESSAGE>
</response>
```

Проверка и проведение платежа

```xml
<?xml version="1.0" encoding="utf-8"?>
<response>
    <EXT_ID>1911105</EXT_ID>
    <REG_DATE>26.11.2019_12:47:21</REG_DATE>
    <AMOUNT>580.00</AMOUNT>
    <CODE>0</CODE>
    <MESSAGE>Платеж принят</MESSAGE>
</response>
```

```xml
<?xml version="1.0" encoding="utf-8"?>
<response>
    <EXT_ID>1911105</EXT_ID>
    <REG_DATE>26.11.2019_12:47:21</REG_DATE>
    <AMOUNT>580.00</AMOUNT>
    <CODE>8</CODE>
    <MESSAGE>Дублирование транзакции</MESSAGE>
</response>
```

Сообщения об ошибках

```xml
<?xml version="1.0" encoding="utf-8"?>
<response>
    <CODE>300</CODE>
    <MESSAGE>Аутентификация не выполнена</MESSAGE>
</response>
```

```xml
<?xml version="1.0" encoding="utf-8"?>
<response>
    <CODE>2</CODE>
    <MESSAGE>Неизвестный тип запроса</MESSAGE>
</response>
```

```xml
<?xml version="1.0" encoding="utf-8"?>
<response>
    <CODE>300</CODE>
    <MESSAGE>Платеж не принят</MESSAGE>
</response>
```

```xml
<?xml version="1.0" encoding="utf-8"?>
<response>
    <CODE>9</CODE>
    <MESSAGE>Неверная сумма платежа</MESSAGE>
</response>
```
