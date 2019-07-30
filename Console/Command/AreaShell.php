<?php

class AreaShell extends AppShell {

    public $uses = array('Area');

    public function main() {
        $this->import();
    }

    public function import() {
        $json = json_decode(file_get_contents(APP . 'webroot/js/cunli.json'), true);
        $db = $this->Area->find('list', array(
            'fields' => array('code', 'id'),
        ));
        foreach ($json['features'] AS $f) {
            if ($f['properties']['COUNTYNAME'] === '臺南市') {
                if (!isset($db[$f['properties']['TOWNCODE']])) {
                    $this->Area->create();
                    $this->Area->save(array('Area' => array(
                            'code' => $f['properties']['TOWNCODE'],
                            'name' => $f['properties']['TOWNNAME'],
                    )));
                    $db[$f['properties']['TOWNCODE']] = $this->Area->getInsertID();
                }
                if (!isset($db[$f['properties']['VILLCODE']])) {
                    $this->Area->create();
                    $this->Area->save(array('Area' => array(
                            'parent_id' => $db[$f['properties']['TOWNCODE']],
                            'code' => $f['properties']['VILLCODE'],
                            'name' => $f['properties']['VILLNAME'],
                    )));
                    $db[$f['properties']['VILLCODE']] = $this->Area->getInsertID();
                }
            }
        }
    }

}
