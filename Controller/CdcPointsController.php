<?php

App::uses('AppController', 'Controller');

class CdcPointsController extends AppController {

    public $name = 'CdcPoints';
    public $paginate = array();
    public $helpers = array();

    public function admin_index() {
        $this->paginate['CdcPoint'] = array(
            'limit' => 20,
            'contain' => array(
                'MemberModified' => array('fields' => array('username')),
                'Area' => array(
                    'fields' => array('name'),
                    'Parent' => array(
                        'fields' => array('name'),
                    )
                ),
            ),
            'order' => array(
                'the_date' => 'DESC'
            ),
        );
        $items = $this->paginate($this->CdcPoint);
        $this->set('items', $items);
    }

    public function admin_import() {
        if (!empty($this->data['CdcPoint']['file']['tmp_name'])) {
            $count = 0;
            $fh = fopen($this->data['CdcPoint']['file']['tmp_name'], 'r');
            /*
             * Array
              (
              [0] =>
              [1] => 查核日期
              [2] => 縣市
              [3] => 區別
              [4] => 里別
              [5] => 查核地址
              [6] => 本署發文日期
              [7] => 文號
              [8] => 臺南市函復日期
              [9] => 文號
              [10] => 複查日期
              [11] => 複查結果
              [12] => 舉發單
              [13] => 說明
              )
             */
            $dbAreas = $this->CdcPoint->Area->find('all', array(
                'conditions' => array(
                    'Area.parent_id IS NOT NULL',
                ),
                'fields' => array('id', 'name'),
                'contain' => array(
                    'Parent' => array(
                        'fields' => array('name'),
                    ),
                ),
            ));
            $areas = array();
            foreach ($dbAreas AS $dbArea) {
                $areas[$dbArea['Parent']['name'] . $dbArea['Area']['name']] = $dbArea['Area']['id'];
            }
            $areaNames = array(
                '中西區赤崁里' => '中西區赤嵌里',
                '安南區公塭里' => '安南區公[塭]里',
                '安南原佃里' => '安南區原佃里',
            );
            $errors = array();
            while ($line = fgetcsv($fh, 2048)) {
                foreach ($line AS $k => $v) {
                    $line[$k] = trim(mb_convert_encoding($v, 'utf-8', 'big5'));
                }
                if ($line[1] === '查核日期') {
                    continue;
                }
                $areaKey = $line[3] . $line[4];
                if (isset($areaNames[$areaKey])) {
                    $areaKey = $areaNames[$areaKey];
                }
                if (isset($areas[$areaKey])) {
                    $dbItem = $this->CdcPoint->find('first', array(
                        'fields' => array('id'),
                        'conditions' => array(
                            'CdcPoint.code' => $line[0],
                        ),
                    ));
                    $dataToSave = array('CdcPoint' => array(
                            'code' => $line[0],
                            'date_found' => $this->twDate($line[1]),
                            'area_id' => $areas[$areaKey],
                            'address' => $line[5],
                            'issue_date' => $this->twDate($line[6]),
                            'issue_no' => $line[7],
                            'issue_reply_date' => $this->twDate($line[8]),
                            'issue_reply_no' => $line[9],
                            'recheck_date' => $this->twDate($line[10]),
                            'recheck_result' => $line[11],
                            'fine' => $line[12],
                            'note' => $line[13],
                    ));
                    if (!empty($dbItem)) {
                        $this->CdcPoint->id = $dbItem['CdcPoint']['id'];
                        $dataToSave['CdcPoint']['modified_by'] = Configure::read('loginMember.id');
                    } else {
                        $this->CdcPoint->create();
                        $dataToSave['CdcPoint']['created_by'] = $dataToSave['CdcPoint']['modified_by'] = Configure::read('loginMember.id');
                    }
                    if ($this->CdcPoint->save($dataToSave)) {
                        ++$count;
                    }
                } else {
                    $errors[] = "[{$line[0]}]{$areaKey}";
                }
            }
            $message = "匯入了 {$count} 筆資料";
            if (!empty($errors)) {
                $message .= '<br />' . implode(',', $errors) . ' 行政區找不到資料';
            }
            $this->Session->setFlash($message);
        }
    }

    private function twDate($stringDate = '') {
        $parts = explode('/', $stringDate);
        if (count($parts) !== 3) {
            return '';
        }
        $parts[0] += 1911;
        return date('Y-m-d', strtotime(implode('/', $parts)));
    }

    function admin_add() {
        if (!empty($this->data)) {
            $this->CdcPoint->create();
            $dataToSave = $this->data;
            $dataToSave['CdcPoint']['created_by'] = $dataToSave['CdcPoint']['modified_by'] = Configure::read('loginMember.id');
            if ($this->CdcPoint->save($dataToSave)) {
                $this->Session->setFlash('資料已經儲存');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('執行時發生錯誤，請重試');
            }
        }
        $this->set('areas', $this->CdcPoint->Area->find('list', array(
                    'conditions' => array(
                        'Area.parent_id IS NULL'
                    ),
                    'order' => array(
                        'Area.code' => 'DESC'
                    ),
        )));
    }

    function admin_edit($id = null) {
        $id = intval($id);
        if ($id > 0) {
            $dbCdcPoint = $this->CdcPoint->find('first', array(
                'conditions' => array(
                    'CdcPoint.id' => $id,
                ),
            ));
        }
        if (empty($dbCdcPoint)) {
            $this->Session->setFlash('請依照網頁指示操作');
            $this->redirect($this->referer());
        }
        if (!empty($this->data)) {
            $dataToSave = $this->data;
            $this->CdcPoint->id = $id;
            $dataToSave['CdcPoint']['modified_by'] = Configure::read('loginMember.id');
            if ($this->CdcPoint->save($dataToSave)) {
                $this->Session->setFlash('資料已經儲存');
                $this->redirect('/admin/cdc_points/index');
            } else {
                $this->Session->setFlash('執行時發生錯誤，請重試');
            }
        }
        $this->data = $dbCdcPoint;
        $this->set('areas', $this->CdcPoint->Area->find('list', array(
                    'conditions' => array(
                        'Area.parent_id IS NULL'
                    ),
                    'order' => array(
                        'Area.code' => 'DESC'
                    ),
        )));
    }

    function admin_delete($id = null) {
        $id = intval($id);
        if ($id > 0) {
            $dbCdcPoint = $this->CdcPoint->find('first', array(
                'conditions' => array(
                    'CdcPoint.id' => $id,
                ),
            ));
        }
        if (empty($dbCdcPoint)) {
            $this->Session->setFlash('請依照網頁指示操作');
            $this->redirect('/');
        } else if ($this->CdcPoint->delete($id)) {
            $this->Session->setFlash('資料已經刪除');
            $this->redirect('/admin/cdc_points/index');
        }
    }

}
