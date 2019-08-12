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
        $nameMap = array(
            '麻豆區?江里' => '麻豆區[晉]江里',
            '麻豆區寮?里' => '麻豆區寮[部]里',
            '安南區公塭里' => '安南區公[塭]里',
            '安南區?田里' => '安南區鹽*田里',
            '安南區塭南里' => '安南區[塭]南里',
            '永康區?興里' => '永康區鹽*興里',
            '永康區?洲里' => '永康區鹽*洲里',
            '永康區?行里' => '永康區[鹽]行里',
            '官田區南?里' => '官田區南[部]里',
            '山上區玉峰里' => '山上區玉[峰]里',
            '龍崎區石??里' => '龍崎區石[曹]里',
            '新化區山?里' => '新化區山[腳]里',
        );
        $areaList = array();
        foreach ($areas AS $area) {
            $areaList["{$area['Parent']['name']}{$area['Area']['name']}"] = $area['Area']['id'];
        }
        $pdoConfig = Configure::read('pdo');
        $dbh = new PDO($pdoConfig['odbc'], $pdoConfig['id'], $pdoConfig['password']);
        //$today = date('Y-m-d');
        //$result = $dbh->query('SELECT * FROM Mosquito_Density1 WHERE DATE = CAST(\'' . $today . '\' AS DATE)');
        $result = $dbh->query('SELECT * FROM Mosquito_Density1 WHERE DATE > CAST(\'2019-06-01\' AS DATE) ORDER BY DATE DESC');
        if ($result) {
            foreach ($result as $row) {
                $areaKey = $row['DISTRICT_NAME'] . $row['VILLAGE_NAME'];
                if (isset($nameMap[$areaKey])) {
                    $areaKey = $nameMap[$areaKey];
                }
                if (isset($areaList[$areaKey])) {
                    $theId = $this->CenterSource->field('id', array(
                        'the_date' => $row['DATE'],
                        'area_id' => $areaList[$areaKey],
                    ));
                    if (empty($theId)) {
                        $this->CenterSource->create();
                    } else {
                        $this->CenterSource->id = $theId;
                    }
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
        }
    }

}
