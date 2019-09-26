<?php

App::uses('AppController', 'Controller');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
                'modified' => 'DESC'
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
                    if (!empty($item['CdcPoint']['recheck_date'])) {
                        ++$pool[$item['CdcPoint']['issue_no']]['done'];
                    }
                    $pool[$item['CdcPoint']['issue_no']]['rows'][] = $item;
                }

                foreach ($pool AS $k => $v) {
                    foreach ($v['rows'] AS $row) {
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
                        isset($item['Area']['Parent']['name']) ? $item['Area']['Parent']['name'] : '',
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
            case '4':
                $result[] = array('', '縣市', '鄉鎮區', '村里', '列管地址', '查核人',
                    '首次缺失說明', '調查地區分類', '抽查日期', '1st複查說明', '1st結果',
                    '1st複查日期', '1st複查查核人', '2nd複查說明', '2nd複查日期', '2nd結果',
                    '2nd複查查核人', '總結果', '衛生局查核',);
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
                        '',
                        '縣市' => '臺南市',
                        '鄉鎮區' => isset($item['Area']['Parent']['name']) ? $item['Area']['Parent']['name'] : '',
                        '村里' => $item['Area']['name'],
                        '列管地址' => $item['CdcPoint']['address'],
                        '查核人' => $item['CdcPoint']['issue_people'],
                        '首次缺失說明' => $item['CdcPoint']['issue_note'],
                        '調查地區分類' => $item['CdcPoint']['issue_type'],
                        '抽查日期' => $item['CdcPoint']['issue_date'],
                        '1st複查說明' => $item['CdcPoint']['recheck_detail'],
                        '1st結果' => $item['CdcPoint']['recheck_result'],
                        '1st複查日期' => $item['CdcPoint']['recheck_date'],
                        '1st複查查核人' => $item['CdcPoint']['recheck_people'],
                        '2nd複查說明' => $item['CdcPoint']['recheck2_detail'],
                        '2nd複查日期' => $item['CdcPoint']['recheck2_date'],
                        '2nd結果' => $item['CdcPoint']['recheck2_result'],
                        '2nd複查查核人' => $item['CdcPoint']['recheck2_people'],
                        '總結果' => $item['CdcPoint']['final_result'],
                        '衛生局查核' => $item['CdcPoint']['recheck_ph_detail'],
                    );
                }

                break;
        }
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $this->layout = 'ajax';
        $this->response->disableCache();
        $this->response->download('report_' . $reportType . '.xlsx');
        $headers = $this->response->header('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        foreach ($headers AS $name => $value) {
            header("{$name}: {$value}");
        }
        if (!empty($result)) {
            $rowIndex = 0;
            foreach ($result AS $line) {
                ++$rowIndex;
                $columnIndex = 0;
                foreach ($line AS $k => $v) {
                    ++$columnIndex;
                    $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $v);
                }
            }
        }
        for ($i = 1; $i <= $columnIndex; $i++) {
            $sheet->getColumnDimensionByColumn($i)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }

    public function admin_import_case() {
        if (!empty($this->data['CdcPoint']['file']['tmp_name'])) {
            $count = 0;
            $fh = fopen($this->data['CdcPoint']['file']['tmp_name'], 'r');
            /*
             * Array
              (
              [0] =>
              [1] =>
              [2] =>
              [3] => area_id
              [4] => address
              [5] => issue_people
              [6] => issue_note
              [7] => issue_type
              [8] => issue_date
              [9] => recheck_detail
              [10] => recheck_result
              [11] => recheck_date
              [12] => recheck_people
              [13] => recheck2_detail
              [14] => recheck2_date
              [15] => recheck2_result
              [16] => recheck2_people
              [17] => final_result
              [18] => recheck_ph_detail
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
                if(!isset($areas[$dbArea['Parent']['name']])) {
                    $areas[$dbArea['Parent']['name']] = $dbArea['Parent']['id'];
                }
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
                if ($line[3] === 'area_id' || empty($line[4]) || $line[4] === '列管地址' || !isset($line[8])) {
                    continue;
                }
                if (mb_substr($line[2], -1, 1, 'utf-8') !== '區') {
                    $line[2] .= '區';
                }
                if (mb_substr($line[3], -1, 1, 'utf-8') !== '里') {
                    $line[3] .= '里';
                }
                $areaKey = $line[2] . $line[3];
                if (isset($areaNames[$areaKey])) {
                    $areaKey = $areaNames[$areaKey];
                }
                $areaConditions = array();
                if(isset($areas[$areaKey])) {
                    $areaConditions['CdcPoint.area_id'] = $areas[$areaKey];
                } elseif(isset($areas[$line[2]])) {
                    $areaConditions['CdcPoint.parent_area_id'] = $areas[$line[2]];
                }
                if (!empty($areaConditions)) {
                    $areaConditions['CdcPoint.address'] = $line[4];
                    $dbItem = $this->CdcPoint->find('first', array(
                        'fields' => array('id'),
                        'conditions' => $areaConditions,
                    ));
                    $dataToSave = array('CdcPoint' => array(
                            'date_found' => date('Y-m-d', strtotime($line[8])),
                            'parent_area_id' => isset($areas[$line[2]]) ? $areas[$line[2]] : 0,
                            'area_id' => isset($areas[$areaKey]) ? $areas[$areaKey] : 0,
                            'address' => $line[4],
                            'issue_people' => $line[5],
                            'issue_note' => $line[6],
                            'issue_type' => $line[7],
                            'recheck_detail' => $line[9],
                            'recheck_date' => date('Y-m-d', strtotime($line[11])),
                            'recheck_result' => $line[10],
                            'recheck_people' => $line[12],
                            'recheck2_detail' => $line[13],
                            'recheck2_date' => $line[14],
                            'recheck2_result' => $line[15],
                            'recheck2_people' => $line[16],
                            'final_result' => $line[17],
                            'recheck_ph_detail' => $line[18],
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
                    $errors[] = "[{$line[2]}]{$areaKey}";
                }
            }
            $message = "匯入了 {$count} 筆資料";
            if (!empty($errors)) {
                $message .= '<br />' . implode(',', $errors) . ' 行政區找不到資料';
            }
            $this->Session->setFlash($message);
        }
        $this->redirect(array('action' => 'import'));
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
                        'fields' => array('id', 'name'),
                    ),
                ),
            ));
            $areas = array();
            foreach ($dbAreas AS $dbArea) {
                $areas[$dbArea['Parent']['name'] . $dbArea['Area']['name']] = $dbArea['Area']['id'];
                if(!isset($areas[$dbArea['Parent']['name']])) {
                    $areas[$dbArea['Parent']['name']] = $dbArea['Parent']['id'];
                }
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
                if ($line[2] === '查核日期' || empty($line[6])) {
                    continue;
                }
                if (mb_substr($line[4], -1, 1, 'utf-8') !== '區') {
                    $line[4] .= '區';
                }
                if (mb_substr($line[5], -1, 1, 'utf-8') !== '里') {
                    $line[5] .= '里';
                }
                $areaKey = $line[4] . $line[5];
                if (isset($areaNames[$areaKey])) {
                    $areaKey = $areaNames[$areaKey];
                }
                $areaConditions = array();
                if(isset($areas[$areaKey])) {
                    $areaConditions['CdcPoint.area_id'] = $areas[$areaKey];
                } elseif(isset($areas[$line[4]])) {
                    $areaConditions['CdcPoint.parent_area_id'] = $areas[$line[4]];
                }
                if (!empty($areaConditions)) {
                    $areaConditions['CdcPoint.address'] = $line[6];
                    $dbItem = $this->CdcPoint->find('first', array(
                        'fields' => array('id'),
                        'conditions' => $areaConditions,
                    ));
                    $dataToSave = array('CdcPoint' => array(
                            'code' => $line[1],
                            'date_found' => $this->twDate($line[2]),
                            'parent_area_id' => isset($areas[$line[4]]) ? $areas[$line[4]] : 0,
                            'area_id' => isset($areas[$areaKey]) ? $areas[$areaKey] : 0,
                            'address' => $line[6],
                            'issue_date' => $this->twDate($line[7]),
                            'issue_no' => $line[8],
                            'issue_reply_date' => $this->twDate($line[9]),
                            'issue_reply_no' => $line[10],
                            'recheck_date' => $this->twDate($line[11]),
                            'recheck_ph_detail' => $line[12],
                            'fine' => $line[13],
                            'note' => $line[14],
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
                    $errors[] = "[{$line[1]}]{$areaKey}";
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
                if (!empty($dataToSave['CdcImage']['file'][0]['size'])) {
                    $pointId = $this->CdcPoint->getInsertID();
                    foreach ($dataToSave['CdcImage']['file'] AS $f) {
                        if (!empty($f['size'])) {
                            $img = array(
                                'cdc_point_id' => $pointId,
                                'file' => CakeText::uuid() . '.jpg',
                                'created_by' => $dataToSave['CdcPoint']['created_by'],
                            );
                            $targetFile = WWW_ROOT . 'uploads/' . $img['file'];
                            $imagick = new Imagick($f['tmp_name']);
                            $imagick->setImageFormat('jpeg');
                            $imagick->setImageCompression(Imagick::COMPRESSION_JPEG);
                            $imagick->setImageCompressionQuality(80);
                            $imagick->thumbnailImage(1280, 1280, false, false);
                            file_put_contents($targetFile, $imagick);
                            $this->CdcPoint->CdcImage->create();
                            $this->CdcPoint->CdcImage->save(array('CdcImage' => $img));
                        }
                    }
                }
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
                'contain' => array(
                    'CdcImage'
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
                if (!empty($dataToSave['CdcImage']['file'][0]['size'])) {
                    foreach ($dataToSave['CdcImage']['file'] AS $f) {
                        if (!empty($f['size'])) {
                            $img = array(
                                'cdc_point_id' => $id,
                                'file' => CakeText::uuid() . '.jpg',
                                'created_by' => $dataToSave['CdcPoint']['modified_by'],
                            );
                            $targetFile = WWW_ROOT . 'uploads/' . $img['file'];
                            $imagick = new Imagick($f['tmp_name']);
                            $imagick->setImageFormat('jpeg');
                            $imagick->setImageCompression(Imagick::COMPRESSION_JPEG);
                            $imagick->setImageCompressionQuality(80);
                            $imagick->thumbnailImage(1280, 1280, false, false);
                            file_put_contents($targetFile, $imagick);
                            $this->CdcPoint->CdcImage->create();
                            $this->CdcPoint->CdcImage->save(array('CdcImage' => $img));
                        }
                    }
                }
                if (!empty($dataToSave['CdcImage']['delete'])) {
                    foreach ($dataToSave['CdcImage']['delete'] AS $imgId) {
                        $imgDb = $this->CdcPoint->CdcImage->read(null, $imgId);
                        if (!empty($imgDb)) {
                            @unlink(WWW_ROOT . 'uploads/' . $imgDb['CdcImage']['file']);
                            $this->CdcPoint->CdcImage->delete($imgId);
                        }
                    }
                }
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
                'contain' => array(
                    'CdcImage',
                ),
            ));
        }
        if (empty($dbCdcPoint)) {
            $this->Session->setFlash('請依照網頁指示操作');
            $this->redirect('/');
        } else if ($this->CdcPoint->delete($id)) {
            foreach ($dbCdcPoint['CdcImage'] AS $img) {
                @unlink(WWW_ROOT . 'uploads/' . $img['file']);
                $this->CdcPoint->CdcImage->delete($img['id']);
            }
            $this->Session->setFlash('資料已經刪除');
            $this->redirect('/admin/cdc_points/index');
        }
    }

    public function admin_bureau_index() {
        $loginMember = Configure::read('loginMember');
        $areas = $this->CdcPoint->Area->find('list', array(
            'fields' => array('Area.id', 'Area.id'),
            'conditions' => array('Area.parent_id' => $loginMember['area_id']),
        ));
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
                'modified' => 'DESC'
            ),
        );
        $items = $this->paginate($this->CdcPoint, array('CdcPoint.area_id' => $areas));
        $this->set('items', $items);
    }

    function admin_bureau_edit($id = null) {
        $id = intval($id);
        if ($id > 0) {
            $loginMember = Configure::read('loginMember');
            $areas = $this->CdcPoint->Area->find('list', array(
                'fields' => array('Area.id', 'Area.id'),
                'conditions' => array('Area.parent_id' => $loginMember['area_id']),
            ));
            $dbCdcPoint = $this->CdcPoint->find('first', array(
                'conditions' => array(
                    'CdcPoint.id' => $id,
                    'CdcPoint.area_id' => $areas,
                ),
                'contain' => array(
                    'CdcImage',
                    'Area' => array(
                        'Parent'
                    ),
                ),
            ));
        }
        if (empty($dbCdcPoint)) {
            $this->Session->setFlash('請依照網頁指示操作');
            $this->redirect('/');
        }
        if (!empty($this->data)) {
            $dataToSave = $this->data;
            $this->CdcPoint->id = $id;
            $dataToSave['CdcPoint']['modified_by'] = Configure::read('loginMember.id');
            if ($this->CdcPoint->save($dataToSave)) {
                if (!empty($dataToSave['CdcImage']['file'][0]['size'])) {
                    foreach ($dataToSave['CdcImage']['file'] AS $f) {
                        if (!empty($f['size'])) {
                            $img = array(
                                'cdc_point_id' => $id,
                                'file' => CakeText::uuid() . '.jpg',
                                'created_by' => $dataToSave['CdcPoint']['modified_by'],
                            );
                            $targetFile = WWW_ROOT . 'uploads/' . $img['file'];
                            $imagick = new Imagick($f['tmp_name']);
                            $imagick->setImageFormat('jpeg');
                            $imagick->setImageCompression(Imagick::COMPRESSION_JPEG);
                            $imagick->setImageCompressionQuality(80);
                            $imagick->thumbnailImage(1280, 1280, false, false);
                            file_put_contents($targetFile, $imagick);
                            $this->CdcPoint->CdcImage->create();
                            $this->CdcPoint->CdcImage->save(array('CdcImage' => $img));
                        }
                    }
                }
                if (!empty($dataToSave['CdcImage']['delete'])) {
                    foreach ($dataToSave['CdcImage']['delete'] AS $imgId) {
                        $imgDb = $this->CdcPoint->CdcImage->read(null, $imgId);
                        if (!empty($imgDb)) {
                            @unlink(WWW_ROOT . 'uploads/' . $imgDb['CdcImage']['file']);
                            $this->CdcPoint->CdcImage->delete($imgId);
                        }
                    }
                }
                $this->Session->setFlash('資料已經儲存');
                $this->redirect('/admin/cdc_points/bureau_index');
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

}
