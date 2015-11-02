<?php

namespace app\models\database;

use yii\db\Connection;

/**
 * Class DatabaseSearch
 * @package app\models\database
 * Класс отвечает за поиск по базе. Вызывается из actionList контроллера SiteController.
 * @var string $sql хранит текст запроса.
 * @var string $connection хранит соединение с базой.
 * @var string $startdate хранит начальную дату поиска.
 * @var string $enddate хранит конечную дату поиска.
 * @var array $result хранит результат поиска.
 * @return $result
 */

class DatabaseSearch
{
    public static function search(array $input)
    {
        $connection = new Connection([
            'dsn' => 'mysql:host=localhost;dbname=work',
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8',
        ]);
        $connection->open();
        /**запрос выбирает имя сети, агенства и сумму
         * с группировкой ао агенству и "ИТОГО"
         * из подзапроса суммы с границами по датам.
         * COALESCE() меняет сумму NULL на 0
         */
        $sql = 'SELECT agency_network.agency_network_name, agency.agency_name, COALESCE(sum(t.amount),0) AS sum
                FROM agency_network
                RIGHT JOIN agency
                ON agency_network.agency_network_id = agency.agency_network_id
                LEFT JOIN
                  (SELECT amount, date, agency_id
                  FROM billing WHERE date BETWEEN :startdate AND :enddate) t
                       ON t.agency_id=agency.agency_id
                GROUP BY agency_name WITH ROLLUP;';

        /*Привязываем параметры с датами, для исключения иньекций*/
        $command = $connection->createCommand($sql)
            ->bindParam(':startdate', $startdate)
            ->bindParam(':enddate', $enddate);
        $startdate = $input[date1];
        $enddate = $input[date2];
        $result = $command->queryAll();
        $connection->close();
        return $result;
    }
}