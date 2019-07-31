<?php

App::uses('AppController', 'Controller');

class AreasController extends AppController {

    public $name = 'Areas';

    public function beforeFilter() {
        parent::beforeFilter();
        if (isset($this->Auth)) {
            $this->Auth->allow(array('cunli'));
        }
    }

    public function center_sources() {
        if (empty($this->data)) {
            $this->data = array(
                'CenterSource' => array(
                    'the_date' => date('Y-m-d')
                ),
            );
        } else {
            $savingCount = 0;
            foreach ($this->data['CenterSource']['area_id'] AS $k => $v) {
                $dataToSave = array(
                    'CenterSource' => array(
                        'the_date' => $this->data['CenterSource']['the_date'],
                        'area_id' => $v,
                        'investigate' => $this->data['CenterSource']['investigate'][$k],
                        'i_water' => $this->data['CenterSource']['i_water'][$k],
                        'i_positive' => $this->data['CenterSource']['i_positive'][$k],
                        'o_water' => $this->data['CenterSource']['o_water'][$k],
                        'o_positive' => $this->data['CenterSource']['o_positive'][$k],
                        'positive_done' => $this->data['CenterSource']['positive_done'][$k],
                        'fine' => $this->data['CenterSource']['fine'][$k],
                        'people' => $this->data['CenterSource']['people'][$k],
                        'note' => $this->data['CenterSource']['note'][$k],
                    ),
                );
                $theId = $this->Area->CenterSource->field('id', array(
                    'the_date' => $dataToSave['CenterSource']['the_date'],
                    'area_id' => $dataToSave['CenterSource']['area_id'],
                ));
                if (empty($theId)) {
                    $this->Area->CenterSource->create();
                    $dataToSave['CenterSource']['created_by'] = $dataToSave['CenterSource']['modified_by'] = Configure::read('loginMember.id');
                } else {
                    $this->Area->CenterSource->id = $theId;
                    $dataToSave['CenterSource']['modified_by'] = Configure::read('loginMember.id');
                }
                if ($this->Area->CenterSource->save($dataToSave)) {
                    ++$savingCount;
                }
            }
            $this->Session->setFlash("已經儲存了 {$savingCount} 筆資料");
        }
        $this->set('areas', $this->Area->find('list', array(
                    'conditions' => array(
                        'Area.parent_id IS NULL'
                    ),
                    'fields' => array('id', 'name'),
                    'order' => array(
                        'Area.code' => 'DESC'
                    ),
        )));
    }

    public function cunli($areaId = 0) {
        $this->layout = 'ajax';
        $areaId = intval($areaId);
        $result = array();
        if ($areaId > 0) {
            $result = $this->Area->find('list', array(
                'fields' => array('id', 'name'),
                'conditions' => array(
                    'Area.parent_id' => $areaId,
                ),
                'order' => array(
                    'Area.code' => 'DESC'
                ),
            ));
        }
        $this->set('result', $result);
    }

    public function health_bureau() {
        $this->set('areas', $this->Area->find('list', array(
                    'conditions' => array(
                        'Area.parent_id IS NULL'
                    ),
                    'order' => array(
                        'Area.code' => 'DESC'
                    ),
        )));
        if (empty($this->data)) {
            $this->data = array(
                'Expand' => array(
                    'the_date' => date('Y-m-d'),
                    'count_p' => 0,
                    'count_n' => 0,
                ),
                'Fever' => array(
                    'count_people' => 0,
                    'count_fever' => 0,
                    'count_draw' => 0,
                    'count_p' => 0,
                    'count_n' => 0,
                ),
                'Track' => array(
                    'track_count' => 0,
                    'track_done' => 0,
                    'fever_count' => 0,
                    'fever_draw' => 0,
                ),
            );
        } else {
            $dataToSave = $this->data;
            $dataToSave['Fever']['the_date'] = $dataToSave['Expand']['the_date'];
            $dataToSave['Fever']['area_id'] = $dataToSave['Expand']['area_id'];
            $dataToSave['Track']['the_date'] = $dataToSave['Expand']['the_date'];
            $dataToSave['Track']['area_id'] = $dataToSave['Expand']['area_id'];

            $expandId = $this->Area->Expand->field('id', array(
                'the_date' => $dataToSave['Expand']['the_date'],
                'area_id' => $dataToSave['Expand']['area_id'],
            ));
            if (empty($expandId)) {
                $this->Area->Expand->create();
                $dataToSave['Expand']['created_by'] = $dataToSave['Fever']['created_by'] = $dataToSave['Track']['created_by'] = $dataToSave['Expand']['modified_by'] = $dataToSave['Fever']['modified_by'] = $dataToSave['Track']['modified_by'] = Configure::read('loginMember.id');
            } else {
                $this->Area->Expand->id = $expandId;
                $dataToSave['Expand']['modified_by'] = $dataToSave['Fever']['modified_by'] = $dataToSave['Track']['modified_by'] = Configure::read('loginMember.id');
            }
            $this->Area->Expand->save($dataToSave);

            $feverId = $this->Area->Fever->field('id', array(
                'the_date' => $dataToSave['Fever']['the_date'],
                'area_id' => $dataToSave['Fever']['area_id'],
            ));
            if (empty($feverId)) {
                $this->Area->Fever->create();
            } else {
                $this->Area->Fever->id = $feverId;
            }
            $this->Area->Fever->save($dataToSave);

            $trackId = $this->Area->Track->field('id', array(
                'the_date' => $dataToSave['Track']['the_date'],
                'area_id' => $dataToSave['Track']['area_id'],
            ));
            if (empty($trackId)) {
                $this->Area->Track->create();
            } else {
                $this->Area->Track->id = $trackId;
            }
            $this->Area->Track->save($dataToSave);
        }
    }

}
