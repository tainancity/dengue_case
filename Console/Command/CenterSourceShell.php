<?php

class CenterSourceShell extends AppShell {

    public $uses = array('CenterSource');

    public function main() {
        $this->import();
    }

    public function import() {
        $pdoConfig = Configure::read('pdo');
        $dbh = new PDO($pdoConfig['odbc'], $pdoConfig['id'], $pdoConfig['password']);
        $result = $dbh->query('SELECT TOP 10 * FROM Mosquito_Density1 WHERE DATE = CAST(\'2019-08-11\' AS DATE) ORDER BY DATE DESC');
        foreach ($result as $row) {
            print_r($row);
        }
    }

}
