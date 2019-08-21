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

    public function admin_export($reportType = '1') {
        $result = array();
        switch ($reportType) {
            case '1':
                $result[] = array('發文日期', '發文字號', '稽督單件數', '地方回復日期', '地方回復方式', '已改善件數', '裁處件數');
                $items = $this->CdcPoint->find('all', array(
                    'order' => array(
                        'issue_date' => 'ASC'
                    ),
                ));
                $pool = array();
                foreach ($items AS $item) {
                    if (!isset($pool[$item['CdcPoint']['issue_no']])) {
                        $pool[$item['CdcPoint']['issue_no']] = array(
                            'date' => $item['CdcPoint']['issue_date'],
                            'count' => 0,
                            'done' => 0,
                            'rows' => array(),
                        );
                    }
                    ++$pool[$item['CdcPoint']['issue_no']]['count'];
                    if(!empty($item['CdcPoint']['recheck_date'])) {
                        ++$pool[$item['CdcPoint']['issue_no']]['done'];
                    }
                    $pool[$item['CdcPoint']['issue_no']]['rows'][] = $item;
                }

                foreach ($pool AS $k => $v) {
                    foreach($v['rows'] AS $row) {
                        $result[] = array($v['date'], $k, $v['count'], $row['CdcPoint']['issue_reply_date'], $row['CdcPoint']['issue_reply_no'], $v['done'], $row['CdcPoint']['fine']);
                    }
                }
                break;
            case '2':
                $result[] = array('發文日期', '發文字號', '稽督單件數');
                $items = $this->CdcPoint->find('all', array(
                    'fields' => array('issue_date', 'issue_no'),
                    'order' => array(
                        'issue_date' => 'ASC'
                    ),
                ));
                $pool = array();
                $count = array(
                    'issue' => 0,
                    'point' => 0,
                );
                foreach ($items AS $item) {
                    if (!isset($pool[$item['CdcPoint']['issue_no']])) {
                        $pool[$item['CdcPoint']['issue_no']] = array(
                            'date' => $item['CdcPoint']['issue_date'],
                            'count' => 0,
                        );
                    }
                    ++$pool[$item['CdcPoint']['issue_no']]['count'];
                    ++$count['point'];
                }

                foreach ($pool AS $k => $v) {
                    ++$count['issue'];
                    $result[] = array($v['date'], $k, $v['count']);
                }
                $result[] = array('總計', $count['issue'], $count['point']);
                break;
            case '3':
                $result[] = array('代碼', '查核日期', '縣市', '區別', '里別', '查核地址', '本署發文日期', '文號', '臺南市函復日期', '文號', '複查日期', '複查結果', '舉發單', '說明');
                $items = $this->CdcPoint->find('all', array(
                    'contain' => array(
                        'Area' => array(
                            'fields' => array('name'),
                            'Parent' => array(
                                'fields' => array('name'),
                            ),
                        ),
                    ),
                    'order' => array(
                        'issue_date' => 'ASC'
                    ),
                ));
                foreach ($items AS $item) {
                    $result[] = array(
                        $item['CdcPoint']['code'],
                        $item['CdcPoint']['date_found'],
                        '臺南市',
                        $item['Area']['Parent']['name'],
                        $item['Area']['name'],
                        $item['CdcPoint']['address'],
                        $item['CdcPoint']['issue_date'],
                        $item['CdcPoint']['issue_no'],
                        $item['CdcPoint']['issue_reply_date'],
                        $item['CdcPoint']['issue_reply_no'],
                        $item['CdcPoint']['recheck_date'],
                        $item['CdcPoint']['recheck_result'],
                        $item['CdcPoint']['fine'],
                        $item['CdcPoint']['note'],
                    );
                }

                break;
        }
        $this->layout = 'ajax';
        $this->response->disableCache();
        $this->response->download('report_' . $reportType . '.csv');
        $headers = $this->response->header('Content-Type', 'application/csv');
        foreach ($headers AS $name => $value) {
            header("{$name}: {$value}");
        }
        $f = fopen('php://memory', 'w');
        if (!empty($result)) {
            foreach ($result AS $line) {
                foreach ($line AS $k => $v) {
                    $line[$k] = mb_convert_encoding($v, 'big5', 'utf-8');
                }
                fputcsv($f, $line);
            }
            fseek($f, 0);
        }
        fpassthru($f);
        exit();
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
