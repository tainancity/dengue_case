<?php

App::uses('AppController', 'Controller');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

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

    public function admin_export() {
        $result = array();
        $result[] = array('編號', '縣市', '鄉鎮區', '村里', '列管地址', '查核人',
            '首次缺失說明', '調查地區分類', '抽查日期', '1st複查說明', '結果',
            '複查日期', '查核人', '2nd複查說明', '複查日期', '結果',
            '查核人', '總結果', '衛生局查核',);
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
                $item['CdcPoint']['code'], //編號
                '臺南市', //縣市
                isset($item['Area']['Parent']['name']) ? $item['Area']['Parent']['name'] : '', //鄉鎮區
                $item['Area']['name'], //村里
                $item['CdcPoint']['address'], //列管地址
                $item['CdcPoint']['issue_people'], //查核人
                $item['CdcPoint']['issue_note'], //首次缺失說明
                $item['CdcPoint']['issue_type'], //調查地區分類
                $item['CdcPoint']['issue_date'], //抽查日期
                $item['CdcPoint']['recheck_detail'], //1st複查說明
                $item['CdcPoint']['recheck_result'], //結果
                $item['CdcPoint']['recheck_date'], //複查日期
                $item['CdcPoint']['recheck_people'], //查核人
                $item['CdcPoint']['recheck2_detail'], //2nd複查說明
                $item['CdcPoint']['recheck2_date'], //複查日期
                $item['CdcPoint']['recheck2_result'], //結果
                $item['CdcPoint']['recheck2_people'], //查核人
                $item['CdcPoint']['final_result'], //總結果
                $item['CdcPoint']['recheck_ph_detail'], //衛生局查核
            );
        }
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('全部');
        $this->layout = 'ajax';
        $this->response->disableCache();
        $this->response->download('report_cdc_points.xlsx');
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

    public function admin_import() {
        if (!empty($this->data['CdcPoint']['file']['tmp_name'])) {
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
                if (!isset($areas[$dbArea['Parent']['name']])) {
                    $areas[$dbArea['Parent']['name']] = $dbArea['Parent']['id'];
                }
            }
            $areaNames = array(
                '中西區赤崁里' => '中西區赤嵌里',
                '安南區公塭里' => '安南區公[塭]里',
                '安南原佃里' => '安南區原佃里',
            );
            $spreadsheet = IOFactory::load($this->data['CdcPoint']['file']['tmp_name']);
            foreach ($spreadsheet->getAllSheets() AS $worksheet) {
                if ($worksheet->getTitle() === '全部') {
                    $count = 0;
                    $highestRow = $worksheet->getHighestRow(); // e.g. 10
                    $highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
                    $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn); // e.g. 5

                    $header = false;
                    for ($row = 1; $row <= $highestRow; ++$row) {
                        $line = array();
                        for ($col = 1; $col <= $highestColumnIndex; ++$col) {
                            $line[] = $worksheet->getCellByColumnAndRow($col, $row)->getFormattedValue();
                        }
                        if (false === $header) {
                            $header = $line;
                            foreach ($header AS $k => $v) {
                                $header[$k] = $k . '-' . $v;
                            }
                        } else {
                            $data = array_combine($header, $line);
                            if (!empty($data['4-列管地址'])) {
                                if (!empty($data['2-鄉鎮區']) && mb_substr($data['2-鄉鎮區'], -1, 1, 'utf-8') !== '區') {
                                    $data['2-鄉鎮區'] .= '區';
                                }
                                if (!empty($data['3-村里']) && mb_substr($data['3-村里'], -1, 1, 'utf-8') !== '里') {
                                    $data['3-村里'] .= '里';
                                }
                                $areaKey = $data['2-鄉鎮區'] . $data['3-村里'];
                                if (isset($areaNames[$areaKey])) {
                                    $areaKey = $areaNames[$areaKey];
                                }
                                $areaConditions = array();
                                if (isset($areas[$areaKey])) {
                                    $areaConditions['CdcPoint.area_id'] = $areas[$areaKey];
                                } elseif (isset($areas[$data['2-鄉鎮區']])) {
                                    $areaConditions['CdcPoint.parent_area_id'] = $areas[$data['2-鄉鎮區']];
                                }
                                if (!empty($areaConditions)) {
                                    $areaConditions['CdcPoint.address'] = $data['4-列管地址'];
                                    $dbItem = $this->CdcPoint->find('first', array(
                                        'fields' => array('id'),
                                        'conditions' => $areaConditions,
                                    ));
                                    $time1 = strtotime($data['8-抽查日期']);
                                    if(false !== $time1) {
                                        $data['8-抽查日期'] = date('Y-m-d', $time1);
                                    } else {
                                        $data['8-抽查日期'] = '';
                                    }
                                    $time1 = strtotime($data['11-複查日期']);
                                    if(false !== $time1) {
                                        $data['11-複查日期'] = date('Y-m-d', $time1);
                                    } else {
                                        $data['11-複查日期'] = '';
                                    }
                                    $time1 = strtotime($data['14-複查日期']);
                                    if(false !== $time1) {
                                        $data['14-複查日期'] = date('Y-m-d', $time1);
                                    } else {
                                        $data['14-複查日期'] = '';
                                    }
                                    $dataToSave = array('CdcPoint' => array(
                                            'code' => $data['0-編號'],
                                            'parent_area_id' => isset($areas[$data['2-鄉鎮區']]) ? $areas[$data['2-鄉鎮區']] : 0,
                                            'area_id' => isset($areas[$areaKey]) ? $areas[$areaKey] : 0,
                                            'address' => $data['4-列管地址'],
                                            'issue_people' => $data['5-查核人'],
                                            'issue_note' => $data['6-首次缺失說明'],
                                            'issue_type' => $data['7-調查地區分類'],
                                            'issue_date' => $data['8-抽查日期'],
                                            'recheck_detail' => $data['9-1st複查說明'],
                                            'recheck_result' => $data['10-結果'],
                                            'recheck_date' => $data['11-複查日期'],
                                            'recheck_people' => $data['12-查核人'],
                                            'recheck2_detail' => $data['13-2nd複查說明'],
                                            'recheck2_date' => $data['14-複查日期'],
                                            'recheck2_result' => $data['15-結果'],
                                            'recheck2_people' => $data['16-查核人'],
                                            'final_result' => $data['17-總結果'],
                                            'recheck_ph_detail' => $data['18-衛生局查核'],
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
                                    $errors[] = "[{$data['2-鄉鎮區']}]{$areaKey}";
                                }
                            }
                        }
                    }
                    $message = "匯入了 {$count} 筆資料";
                    $this->Session->setFlash($message);
                }
            }
        }
    }

    private function twDate($stringDate = '') {
        $parts = explode('/', $stringDate);
        if (count($parts) !== 3) {
            $parts = explode('-', $stringDate);
            if(count($parts) !== 3) {
                return '';
            } else {
                return $stringDate;
            }
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
