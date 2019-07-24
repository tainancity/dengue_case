<?php

App::uses('AppController', 'Controller');

class IssuesController extends AppController {

    public $name = 'Issues';
    public $paginate = array();
    public $helpers = array();

    function admin_index() {
        $this->paginate['Issue'] = array(
            'limit' => 20,
            'contain' => array(
                'MemberCreated' => array('fields' => 'username'),
                'MemberModified' => array('fields' => 'username'),
            ),
        );
        $this->set('items', $this->paginate($this->Issue));
    }

    function admin_view($id = null) {
        if (!$id || !$this->data = $this->Issue->find('first', array(
            'conditions' => array('Issue.id' => $id),
            'contain' => array(
                'Point',
                'MemberCreated' => array('fields' => 'username'),
                'MemberModified' => array('fields' => 'username'),
            ),
                ))) {
            $this->Session->setFlash('請依照網頁指示操作');
            $this->redirect(array('action' => 'index'));
        }
    }

    function admin_add() {
        if (!empty($this->data)) {
            $this->Issue->create();
            if ($this->Issue->save($this->data)) {
                $this->Session->setFlash('資料已經儲存');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('執行時發生錯誤，請重試');
            }
        }
    }

    function admin_edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash('請依照網頁指示操作');
            $this->redirect($this->referer());
        }
        if (!empty($this->data)) {
            $this->Issue->id = $id;
            if ($this->Issue->save($this->data)) {
                $this->Session->setFlash('資料已經儲存');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('執行時發生錯誤，請重試');
            }
        }
        $this->set('id', $id);
        $this->data = $this->Issue->read(null, $id);
    }

    function admin_delete($id = null) {
        if (!$id) {
            $this->Session->setFlash('請依照網頁指示操作');
        } else if ($this->Issue->delete($id)) {
            $this->Session->setFlash('資料已經刪除');
        }
        $this->redirect(array('action' => 'index'));
    }

    function admin_export() {
        $issues = $this->Issue->find('all', array(
            'conditions' => array(
                'Issue.report_type' => '1',
            ),
            'contain' => array('Point')
        ));
        $fh = fopen('php://memory', 'w');
        $line = array('個案序', '顯示名稱', '通報日', '姓名', '地點類型', '區里', '完整地址', '座標', '定位用', '備註');
        foreach ($line AS $k => $v) {
            $line[$k] = mb_convert_encoding($v, 'big5', 'utf-8');
        }
        fputcsv($fh, $line);
        foreach ($issues AS $issue) {
            $line = array(
                $issue['Issue']['code'],
                $issue['Issue']['label'],
                $issue['Issue']['reported'],
                $issue['Issue']['name'],
                '居住地',
                '居住地',
                $issue['Issue']['cunli'],
                $issue['Issue']['address'],
                "{$issue['Issue']['latitude']}, {$issue['Issue']['longitude']}",
                $issue['Issue']['address'],
                $issue['Issue']['note'],
            );
            foreach ($line AS $k => $v) {
                $line[$k] = mb_convert_encoding($v, 'big5', 'utf-8');
            }
            fputcsv($fh, $line);
            foreach ($issue['Point'] AS $point) {
                if ($point['point_type'] == 1) {
                    $pointType = '工作地';
                } else {
                    $pointType = '活動地';
                }
                $line = array(
                    $issue['Issue']['code'],
                    $issue['Issue']['label'],
                    $issue['Issue']['reported'],
                    $issue['Issue']['name'],
                    $pointType,
                    $point['label'],
                    $point['cunli'],
                    $point['address'],
                    "{$point['latitude']}, {$point['longitude']}",
                    $point['address'],
                    $issue['Issue']['note'],
                );
                foreach ($line AS $k => $v) {
                    $line[$k] = mb_convert_encoding($v, 'big5', 'utf-8');
                }
                fputcsv($fh, $line);
            }
        }
        fseek($fh, 0);
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="data.csv";');
        fpassthru($fh);
        exit();
    }

    function admin_import() {
        /*
         * Array
          (
          [0] => 個案序
          [1] => 顯示名稱
          [2] => 通報日
          [3] => 姓名
          [4] => 地點類型
          [5] => 地點名稱
          [6] => 區里
          [7] => 完整地址
          [8] => 座標
          [9] => 定位用
          [10] => 備註
          )
         */
        if (!empty($this->data['Issue']['file']['tmp_name'])) {
            $count = 0;
            $fh = fopen($this->data['Issue']['file']['tmp_name'], 'r');
            while ($line = fgetcsv($fh, 2048)) {
                foreach ($line AS $k => $v) {
                    $line[$k] = trim(mb_convert_encoding($v, 'utf-8', 'big5'));
                }
                if ($line[0] === '個案序') {
                    continue;
                }
                $dbIssue = $this->Issue->find('first', array(
                    'fields' => array('id'),
                    'conditions' => array(
                        'Issue.code' => $line[0],
                    ),
                ));
                $dateReported = preg_split('/(年|月|日|\\-)/i', $line[2]);
                if (count($dateReported) === 3 && empty($dateReported[2])) {
                    $dateReported = date('Y-m-d', mktime(0, 0, 0, $dateReported[0], $dateReported[1], date('Y')));
                } else {
                    $dateReported = implode('-', $dateReported);
                }
                $longitude = $latitude = null;
                if (!empty($line[8])) {
                    $parts = explode(',', $line[8]);
                    foreach ($parts AS $k => $v) {
                        $parts[$k] = floatval(trim($v));
                    }
                    $longitude = $parts[1];
                    $latitude = $parts[0];
                }
                if (!empty($dbIssue)) {
                    $this->Issue->id = $dbIssue['Issue']['id'];
                } else {
                    $this->Issue->create();
                }
                $pointType = 0;
                if (false !== strpos($line[4], '活動')) {
                    $pointType = 2;
                } else if (false !== strpos($line[4], '工作')) {
                    $pointType = 1;
                }
                $issueToSave = array('Issue' => array(
                        'code' => $line[0],
                        'name' => $line[3],
                        'report_type' => '1',
                ));
                if ($pointType == 0) {
                    $issueToSave['Issue']['label'] = $line[1];
                    $issueToSave['Issue']['reported'] = $dateReported;
                    $issueToSave['Issue']['address'] = $line[7];
                    $issueToSave['Issue']['cunli'] = $line[6];
                    $issueToSave['Issue']['longitude'] = $longitude;
                    $issueToSave['Issue']['latitude'] = $latitude;
                    $issueToSave['Issue']['note'] = $line[10];
                }
                if ($this->Issue->save($issueToSave)) {
                    ++$count;
                    if (empty($dbIssue)) {
                        $dbIssue = array('Issue' => array(
                                'id' => $this->Issue->getInsertID(),
                        ));
                    }
                    if ($pointType !== 0) {
                        $dbPoint = $this->Issue->Point->find('first', array(
                            'fields' => array('id'),
                            'conditions' => array(
                                'Point.Issue_id' => $dbIssue['Issue']['id'],
                                'Point.point_type' => $pointType,
                            ),
                        ));
                        if (empty($dbPoint['Point']['id'])) {
                            $this->Issue->Point->create();
                        } else {
                            $this->Issue->Point->id = $dbPoint['Point']['id'];
                        }
                        $this->Issue->Point->save(array('Point' => array(
                                'Issue_id' => $dbIssue['Issue']['id'],
                                'point_type' => $pointType,
                                'label' => $line[5],
                                'address' => $line[7],
                                'cunli' => $line[6],
                                'longitude' => $longitude,
                                'latitude' => $latitude,
                        )));
                    }
                }
            }
            $this->Session->setFlash("匯入了 {$count} 筆資料");
        }
    }

    function admin_import_report() {
        /*
         * Array
          (
          [0] => 序號
          [1] => 通報編號或Bar-Code
          [2] => 姓名
          [3] => 顯示名稱
          [4] => 類型
          [5] => IgM
          [6] => IgG
          [7] => 區里
          [8] => 地址
          [9] => 完整地址
          [10] => 座標
          [11] => 定位用
          [12] => 備註
          )
         */
        if (!empty($this->data['Issue']['file']['tmp_name'])) {
            $count = 0;
            $fh = fopen($this->data['Issue']['file']['tmp_name'], 'r');
            while ($line = fgetcsv($fh, 2048)) {
                foreach ($line AS $k => $v) {
                    $line[$k] = trim(mb_convert_encoding($v, 'utf-8', 'big5'));
                }
                if ($line[0] === '序號') {
                    continue;
                }
                $dbIssue = $this->Issue->find('first', array(
                    'fields' => array('id'),
                    'conditions' => array(
                        'Issue.code' => $line[1],
                    ),
                ));
                $longitude = $latitude = null;
                if (!empty($line[10])) {
                    $parts = explode(',', $line[10]);
                    foreach ($parts AS $k => $v) {
                        $parts[$k] = floatval(trim($v));
                    }
                    $longitude = $parts[1];
                    $latitude = $parts[0];
                }
                if (!empty($dbIssue)) {
                    $this->Issue->id = $dbIssue['Issue']['id'];
                } else {
                    $this->Issue->create();
                }
                if (false !== strpos($line[4], '通報')) {
                    $reportType = '2';
                } else {
                    $reportType = '3';
                }
                $issueToSave = array('Issue' => array(
                        'code' => $line[1],
                        'name' => $line[2],
                        'report_type' => $reportType,
                        'label' => $line[3],
                        'address' => $line[9],
                        'cunli' => $line[7],
                        'igm' => $line[5],
                        'igg' => $line[6],
                        'longitude' => $longitude,
                        'latitude' => $latitude,
                        'note' => $line[12],
                ));
                if ($this->Issue->save($issueToSave)) {
                    ++$count;
                }
            }
            $this->Session->setFlash("匯入了 {$count} 筆資料");
        }
        $this->redirect(array('action' => 'import'));
    }

    function admin_export_report() {
        $issues = $this->Issue->find('all', array(
            'conditions' => array(
                'OR' => array(
                    'Issue.report_type' => '2',
                    'Issue.report_type' => '3',
                ),
            ),
        ));
        $fh = fopen('php://memory', 'w');
        $line = array('序號', '通報編號或Bar-Code', '姓名', '顯示名稱', '類型', 'IgM', 'IgG', '區里', '地址', '完整地址', '座標', '定位用', '備註');
        foreach ($line AS $k => $v) {
            $line[$k] = mb_convert_encoding($v, 'big5', 'utf-8');
        }
        fputcsv($fh, $line);
        foreach ($issues AS $issue) {
            $reportType = '擴大疫採';
            if ($issue['Issue']['report_type'] == '2') {
                $reportType = '通報追蹤';
            }
            $line = array(
                $issue['Issue']['code'],
                $issue['Issue']['code'],
                $issue['Issue']['name'],
                $issue['Issue']['label'],
                $reportType,
                $issue['Issue']['igm'],
                $issue['Issue']['igg'],
                $issue['Issue']['cunli'],
                $issue['Issue']['address'],
                $issue['Issue']['address'],
                "{$issue['Issue']['latitude']}, {$issue['Issue']['longitude']}",
                $issue['Issue']['address'],
                $issue['Issue']['note'],
            );
            foreach ($line AS $k => $v) {
                $line[$k] = mb_convert_encoding($v, 'big5', 'utf-8');
            }
            fputcsv($fh, $line);
        }
        fseek($fh, 0);
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="data.csv";');
        fpassthru($fh);
        exit();
    }

}
