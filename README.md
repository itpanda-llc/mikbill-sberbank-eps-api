# MikBill-Sberbank-EPS-API

API для интеграции биллинговой системы ["MikBill"](https://mikbill.pro) с единой платежной системой [ПАО "Сбербанка"](https://sberbank.ru)

[![Packagist Downloads](https://img.shields.io/packagist/dt/itpanda-llc/mikbill-sberbank-eps-api)](https://packagist.org/packages/itpanda-llc/mikbill-sberbank-eps-api/stats)
![Packagist License](https://img.shields.io/packagist/l/itpanda-llc/mikbill-sberbank-eps-api)
![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/itpanda-llc/mikbill-sberbank-eps-api)

## Ссылки

* [Разработка](https://github.com/itpanda-llc)
* [О проекте (MikBill)](https://mikbill.pro)
* [О проекте (Сбербанк)](https://sberbank.ru)
* [Документация (MikBill)](https://wiki.mikbill.pro)
* [Документация (Сбербанк)](https://www.sberbank.ru/common/img/uploaded/files/pdf/payments_receiving/usloviya_po_dogovoru_online.pdf)

## Возможности

* Проверка идентификатора плательщика
* Создание платежной транзакции

## Требования

* PHP >= 7.2
* libxml
* PDO
* SimpleXML
* vlucas/phpdotenv ^5.3
  
## Установка

```shell script
composer require itpanda-llc/mikbill-sberbank-eps-api
```

## Конфигурация

* Копирование файла [".env.example"](.env.example) в ".env"

```shell script
copy .env.example .env
```

* Указание параметров в файле ".env"
* Указание путей к интерфейсу в файле ["index.php"](examples/www/mikbill/admin/api/sberbank/eps/index.php), предварительно размещенного в каталоге веб-сервера

## Примеры ответов интерфейса

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

```xml
<?xml version="1.0" encoding="utf-8"?>
<response>
    <EXT_ID>191120</EXT_ID>
    <REG_DATE>16.11.2019_14:02:10</REG_DATE>
    <AMOUNT>580.00</AMOUNT>
    <CODE>0</CODE>
    <MESSAGE>Платеж принят</MESSAGE>
</response>
```

```xml
<?xml version="1.0" encoding="utf-8"?>
<response>
    <EXT_ID>191120</EXT_ID>
    <REG_DATE>16.11.2019_14:02:10</REG_DATE>
    <AMOUNT>580.00</AMOUNT>
    <CODE>8</CODE>
    <MESSAGE>Дублирование транзакции</MESSAGE>
</response>
```

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
    <CODE>3</CODE>
    <MESSAGE>Абонент не найден</MESSAGE>
</response>
```
