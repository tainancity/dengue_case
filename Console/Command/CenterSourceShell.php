<?php

class CenterSourceShell extends AppShell {

    public $uses = array('CenterSource');

    public function main() {
        $this->import();
    }

    public function import() {
        $areas = $this->CenterSource->Area->find('all', array(
            'fields' => array('Area.id', 'Area.parent_id', 'name'),
            'conditions' => array('Area.parent_id IS NOT NULL'),
            'contain' => array('Parent' => array(
                    'fields' => array('id', 'name'),
                )),
        ));
        $areaList = array();
        foreach ($areas AS $area) {
            $areaList["{$area['Parent']['name']}{$area['Area']['name']}"] = $area['Area']['id'];
        }
        $pdoConfig = Configure::read('pdo');
        $dbh = new PDO($pdoConfig['odbc'], $pdoConfig['id'], $pdoConfig['password']);
        //$today = date('Y-m-d');
        //$result = $dbh->query('SELECT * FROM Mosquito_Density1 WHERE DATE = CAST(\'' . $today . '\' AS DATE)');
        $result = $dbh->query('SELECT * FROM Mosquito_Density1 ORDER BY DATE DESC');
        if ($result) {
            $errorPool = array();
            foreach ($result as $row) {
                $areaKey = $row['DISTRICT_NAME'] . $row['VILLAGE_NAME'];
                if (!isset($areaList[$areaKey])) {
                    $errorPool[$areaKey] = true;
                } else {
                    $this->CenterSource->create();
                    $this->CenterSource->save(array('CenterSource' => array(
                            'the_date' => $row['DATE'],
                            'area_id' => $areaList[$areaKey],
                            'investigate' => $row['SURVEY_HOUSEHOLD'],
                            'positive_done' => $row['POSITIVE_HOUSEHOLD'],
                            'i_water' => $row['SURVEY_CONTAINER_IN'],
                            'o_water' => $row['SURVEY_CONTAINER_OUT'],
                            'i_positive' => $row['POSITIVE_CONTAINER_IN'],
                            'o_positive' => $row['POSITIVE_CONTAINER_OUT'],
                    )));
                }
            }
            echo var_export($errorPool);
        }
    }

}
