<?php

/**
 * Файл из репозитория MikBill-Sberbank-EPS-PHP-API
 * @link https://github.com/itpanda-llc
 */

namespace Panda\MikBill\Sberbank\EPSAPI;

/**
 * Class SQL
 * @package Panda\MikBill\Sberbank\EPSAPI
 * SQL-запросы
 */
class SQL
{
    /**
     * Получение аккаунта
     */
    public const GET_ACCOUNT = "
        SELECT
            CONCAT(
                SUBSTRING(
                    @surname :=
                    (
                        SUBSTRING(
                            `clients`.`fio`,
                            1,
                            (
                                LOCATE(
                                    ' ', `clients`.`fio`
                                ) - 1
                            )
                        )
                    ), 1, 1 
                ),
                REPEAT(
                    '*', 
                    (
                        LENGTH(
                            @surname
                        ) - 1
                    )
                ), ' ',
                SUBSTRING(
                    @name :=
                    (
                        SUBSTRING(
                            @name :=
                            (
                                SUBSTRING(
                                    `clients`.`fio`,
                                    @locate :=
                                    (
                                        LOCATE(
                                            ' ',
                                            SUBSTRING(
                                                `clients`.`fio`, 1,
                                                (
                                                    LOCATE(
                                                        ' ', `clients`.`fio`
                                                    ) + 1
                                                )
                                            )
                                        ) + 1
                                    )
                                )
                            ), 1,
                            IF(
                                0 != @lengthname :=
                                (
                                    LENGTH(
                                        SUBSTRING(
                                            @name, 1,
                                            (
                                                LOCATE(
                                                    ' ', @name
                                                ) - 1
                                            )
                                        )
                                    )
                                ),
                                @lengthname,
                                LENGTH(@name)
                            )
                        )
                    ), 1, 1
                ),
                REPEAT(
                    '*',
                    (
                        LENGTH(
                            @name
                        ) - 1
                    )
                ),
                IF(
                    @name != @patronymic :=
                    (
                        SUBSTRING(
                            SUBSTRING(
                                `clients`.`fio`, @locate
                            ),
                            (
                                LOCATE(
                                    ' ',
                                    SUBSTRING(
                                        `clients`.`fio`, @locate
                                    )
                                ) + 1
                            )
                        )
                    ),
                    CONCAT(
                        ' ',
                        SUBSTRING(
                            @patronymic, 1, 1
                        ),
                        REPEAT(
                            '*',
                            (
                                LENGTH(
                                    @patronymic
                                ) - 1
                            )
                        )
                    ), ''
                )
            ) AS
                `" . Field::FIO . "`,
            CONCAT(
                REPLACE(
                    `lanes`.`lane`, '.', ''
                ), ', ',
                CASE
                    WHEN
                        `clients`.`app` = ''
                    THEN
                        `lanes_houses`.`house`
                    WHEN
                        `clients`.`app` != ''
                    THEN
                        CONCAT(
                            `lanes_houses`.`house`,
                            ', ',
                            `clients`.`app`
                        )
                END
            ) AS
                `" . Field::ADDRESS . "`,
            ROUND(
                `clients`.`deposit`, 2
            ) AS
                `" . Field::BALANCE . "`,
            CONCAT_WS(
                ' // ',
                CONCAT(
                    IF(
                        (
                            `clients`.`mob_tel` IS NOT NULL
                                AND
                            `clients`.`mob_tel` != ''
                        ), '+', ''
                    ),
                    LEFT(
                        `clients`.`mob_tel`, 1
                    ),
                    REPEAT(
                        '*',
                        (
                            LENGTH(
                                `clients`.`mob_tel`
                            ) - 3
                        )
                    ),
                    RIGHT(
                        `clients`.`mob_tel`, 2
                    )
                ),
                '" . Service::NAME . "',
                `clients`.`numdogovor`,
                CONVERT(
                    (
                        CASE
                            WHEN
                                `clients`.`freeze_date` IS NOT NULL
                            THEN
                                'Заморожен'
                            WHEN
                                `clients`.`block_date` IS NOT NULL
                            THEN
                                'Заблокирован'
                            WHEN
                                `clients`.`del_date` IS NOT NULL
                            THEN
                                'Удален'
                            WHEN
                                `clients`.`blocked` = 0
                            THEN
                                'Активен'
                            WHEN
                                `clients`.`blocked` = 1
                            THEN
                                'Остановлен'
                        END
                    ),
                    CHAR
                )
            ) AS
                `" . Field::INFO . "`
        FROM
            (
                SELECT
                    `users`.`user`,
                    `users`.`deposit`,
                    `users`.`fio`,
                    `users`.`blocked`,
                    `users`.`mob_tel`,
                    `users`.`numdogovor`,
                    `users`.`app`,
                    `users`.`houseid`,
                    NULL AS
                        `freeze_date`,
                    NULL AS
                        `block_date`,
                    NULL AS
                        `del_date`
                FROM
                   `users`
                UNION
                SELECT
                    `usersfreeze`.`user`,
                    `usersfreeze`.`deposit`,
                    `usersfreeze`.`fio`,
                    `usersfreeze`.`blocked`,
                    `usersfreeze`.`mob_tel`,
                    `usersfreeze`.`numdogovor`,
                    `usersfreeze`.`app`,
                    `usersfreeze`.`houseid`,
                    `usersfreeze`.`freeze_date`,
                    NULL AS
                        `block_date`,
                    NULL AS
                        `del_date`
                FROM
                    `usersfreeze`
                UNION
                SELECT
                    `usersblok`.`user`,
                    `usersblok`.`deposit`,
                    `usersblok`.`fio`,
                    `usersblok`.`blocked`,
                    `usersblok`.`mob_tel`,
                    `usersblok`.`numdogovor`,
                    `usersblok`.`app`,
                    `usersblok`.`houseid`,
                    NULL AS
                        `freeze_date`,
                    `usersblok`.`block_date`,
                    NULL AS
                        `del_date`
                    
                FROM
                    `usersblok`
                UNION
                SELECT
                    `usersdel`.`user`,
                    `usersdel`.`deposit`,
                    `usersdel`.`fio`,
                    `usersdel`.`blocked`,
                    `usersdel`.`mob_tel`,
                    `usersdel`.`numdogovor`,
                    `usersdel`.`app`,
                    `usersdel`.`houseid`,
                    NULL AS
                        `freeze_date`,
                    NULL AS
                        `block_date`,
                    `usersdel`.`del_date`
                FROM
                    `usersdel`
            ) AS
                `clients`
        LEFT JOIN
            `lanes_houses`
                ON
                    `lanes_houses`.`houseid` = `clients`.`houseid`
        LEFT JOIN
            `lanes`
                ON
                    `lanes`.`laneid` = `lanes_houses`.`laneid`
        WHERE
            `clients`.`fio` != ''
                AND
            `clients`.`user` = " . Holder::ACCOUNT;

    /**
     * Получение платежа
     */
    public const GET_PAYMENT = "
        SELECT
            IF(
                `addons_pay_api`.`transaction_id` = 0,
                CONCAT(
                    DATE_FORMAT(
                        NOW(),
                        '%y%m'
                    ),
                    `addons_pay_api`.`record_id`
                ),
                `addons_pay_api`.`transaction_id`
            ) AS
                `" . Field::EXT_ID . "`,
            DATE_FORMAT(
                `addons_pay_api`.`creation_time`,
                '%d.%m.%Y_%H:%i:%s'
            ) AS 
                `" . Field::REG_DATE . "`,
            ROUND(
                `addons_pay_api`.`amount`, 2
            ) AS
                `" . Field::AMOUNT . "`
        FROM
            `addons_pay_api`
        WHERE
            `addons_pay_api`.`category` = " . Category::ID . "
                AND
            `addons_pay_api`.`misc_id` = " . Holder::PAY_ID;

    /**
     * Проверка наличия категории платежа
     */
    public const CHECK_CATEGORY = "
        SELECT
            `addons_pay_api_category`.`category`
        FROM
            `addons_pay_api_category`
        WHERE
            `addons_pay_api_category`.`category` = " . Category::ID;

    /**
     * Добавление категории платежа
     */
    public const ADD_CATEGORY = "
        INSERT INTO 
            `addons_pay_api_category` (
                `category`,
                `categoryname`
            )
        VALUES (
            " . Category::ID . ",
            '" . Category::NAME . "'
        )";

    /**
     * Добавление платежа
     */
    public const ADD_PAYMENT = "
        INSERT INTO
            `addons_pay_api` (
                `misc_id`,
                `category`,
                `user_ref`,
                `amount`,
                `creation_time`,
                `update_time`,
                `comment`
            )
        VALUES (
            " . Holder::PAY_ID . ",
            " . CATEGORY::ID . ",
            (
                SELECT
                    `clients`.`uid`
                FROM
                    (
                        SELECT
                            `users`.`user`,
                            `users`.`uid`
                        FROM
                            `users`
                        UNION
                        SELECT
                            `usersfreeze`.`user`,
                            `usersfreeze`.`uid`
                        FROM
                            `usersfreeze`
                        UNION
                        SELECT
                            `usersblok`.`user`,
                            `usersblok`.`uid`
                        FROM
                            `usersblok`
                        UNION
                        SELECT
                            `usersdel`.`user`,
                            `usersdel`.`uid`
                        FROM
                            `usersdel`
                    ) AS
                        `clients`
                WHERE
                    `clients`.`user` = " . Holder::ACCOUNT . "
            ),
            " . Holder::AMOUNT . ",
            NOW(),
            NOW(),
            '" . Payment::COMMENT . "'
        )";

    /**
     * Подготовление платежа
     */
    public const SET_PAYMENT = "
        UPDATE
            `addons_pay_api`
        SET
            `addons_pay_api`.`transaction_id`
                =
            CONCAT(
                DATE_FORMAT(
                    NOW(),
                    '%y%m'
                ),
                `addons_pay_api`.`record_id`
            )
        WHERE
            `addons_pay_api`.`misc_id`= " . Holder::PAY_ID;
}
