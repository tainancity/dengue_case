<?php

App::uses('AppController', 'Controller');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class CdcIssuesController extends AppController {

    public $name = 'CdcIssues';
    public $paginate = array();
    public $helpers = array();

    public function admin_index() {
        $this->paginate['CdcIssue'] = array(
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
        $items = $this->paginate($this->CdcIssue);
        $this->set('items', $items);
    }

    public function admin_export() {
        $result = array();
        $result[] = array('流水號', '', '查核日期', '縣市', '區別', '里別', '查核地址', '本署發文日期', '疾管南區管文號', '臺南市函復日期', '府登防文號', '複查日期', '複查結果', '舉發單', '說明');
        $items = $this->CdcIssue->find('all', array(
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
        $count = 0;
        foreach ($items AS $item) {
            $result[] = array(
                ++$count,
                $item['CdcIssue']['code'],
                $item['CdcIssue']['date_found'],
                '臺南市',
                isset($item['Area']['Parent']['name']) ? $item['Area']['Parent']['name'] : '',
                $item['Area']['name'],
                $item['CdcIssue']['address'],
                $item['CdcIssue']['issue_date'],
                $item['CdcIssue']['issue_no'],
                $item['CdcIssue']['issue_reply_date'],
                $item['CdcIssue']['issue_reply_no'],
                $item['CdcIssue']['recheck_date'],
                $item['CdcIssue']['recheck_ph_detail'],
                $item['CdcIssue']['fine'],
                $item['CdcIssue']['note'],
            );
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('稽督單細項');
        $this->layout = 'ajax';
        $this->response->disableCache();
        $this->response->download('report_cdc_issues.xlsx');
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
        if (!empty($this->data['CdcIssue']['file']['tmp_name'])) {
            $count = $countDuplicated = 0;
            $dbAreas = $this->CdcIssue->Area->find('all', array(
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
                if (!isset($areas[$dbArea['Parent']['name']])) {
                    $areas[$dbArea['Parent']['name']] = $dbArea['Parent']['id'];
                }
            }
            $areaNames = array(
                '中西區赤崁里' => '中西區赤嵌里',
                '安南區公塭里' => '安南區公[塭]里',
                '安南原佃里' => '安南區原佃里',
            );
            $errors = array();
            $spreadsheet = IOFactory::load($this->data['CdcIssue']['file']['tmp_name']);
            foreach ($spreadsheet->getAllSheets() AS $worksheet) {
                if ($worksheet->getTitle() === '稽督單細項') {
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
                            if (!empty($data['6-查核地址'])) {
                                if (mb_substr($data['4-區別'], -1, 1, 'utf-8') !== '區') {
                                    $data['4-區別'] .= '區';
                                }
                                if (mb_substr($data['5-里別'], -1, 1, 'utf-8') !== '里') {
                                    $data['5-里別'] .= '里';
                                }
                                $areaKey = $data['4-區別'] . $data['5-里別'];
                                if (isset($areaNames[$areaKey])) {
                                    $areaKey = $areaNames[$areaKey];
                                }
                                $areaConditions = array();
                                if (isset($areas[$areaKey])) {
                                    $areaConditions['CdcIssue.area_id'] = $areas[$areaKey];
                                } elseif (isset($areas[$line[4]])) {
                                    $areaConditions['CdcIssue.parent_area_id'] = $areas[$data['4-區別']];
                                }
                                if (!empty($areaConditions)) {
                                    $areaConditions['CdcIssue.address'] = $data['6-查核地址'];
                                    $dbItem = $this->CdcIssue->find('first', array(
                                        'fields' => array('id'),
                                        'conditions' => $areaConditions,
                                    ));
                                    $dataToSave = array('CdcIssue' => array(
                                            'code' => $data['1-'],
                                            'date_found' => $this->twDate($data['2-查核日期']),
                                            'parent_area_id' => isset($areas[$data['4-區別']]) ? $areas[$data['4-區別']] : 0,
                                            'area_id' => isset($areas[$areaKey]) ? $areas[$areaKey] : 0,
                                            'address' => $data['6-查核地址'],
                                            'issue_date' => $this->twDate($data['7-本署發文日期']),
                                            'issue_no' => $data['8-疾管南區管文號'],
                                            'issue_reply_date' => $this->twDate($data['9-臺南市函復日期']),
                                            'issue_reply_no' => $data['10-府登防文號'],
                                            'recheck_date' => $this->twDate($data['11-複查日期']),
                                            'recheck_ph_detail' => $data['12-複查結果'],
                                            'fine' => $data['13-舉發單'],
                                            'note' => $data['14-說明'],
                                    ));
                                    if (!empty($dbItem)) {
                                        $this->CdcIssue->id = $dbItem['CdcIssue']['id'];
                                        $dataToSave['CdcIssue']['modified_by'] = Configure::read('loginMember.id');
                                        ++$countDuplicated;
                                    } else {
                                        $this->CdcIssue->create();
                                        $dataToSave['CdcIssue']['created_by'] = $dataToSave['CdcIssue']['modified_by'] = Configure::read('loginMember.id');
                                        ++$count;
                                    }
                                    $this->CdcIssue->save($dataToSave);
                                } else {
                                    $errors[] = "[{$data['1-']}]{$areaKey}";
                                }
                            }
                        }
                    }
                    $message = "匯入了 {$count} 筆新資料，更新 {$countDuplicated} 筆資料";
                    if (!empty($errors)) {
                        $message .= '<br />' . implode(',', $errors) . ' 行政區找不到資料';
                    }
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
            $this->CdcIssue->create();
            $dataToSave = $this->data;
            $dataToSave['CdcIssue']['created_by'] = $dataToSave['CdcIssue']['modified_by'] = Configure::read('loginMember.id');
            if ($this->CdcIssue->save($dataToSave)) {
                if (!empty($dataToSave['CdcImage']['file'][0]['size'])) {
                    $pointId = $this->CdcIssue->getInsertID();
                    foreach ($dataToSave['CdcImage']['file'] AS $f) {
                        if (!empty($f['size'])) {
                            $img = array(
                                'cdc_issue_id' => $pointId,
                                'file' => CakeText::uuid() . '.jpg',
                                'created_by' => $dataToSave['CdcIssue']['created_by'],
                            );
                            $targetFile = WWW_ROOT . 'uploads/' . $img['file'];
                            $imagick = new Imagick($f['tmp_name']);
                            $imagick->setImageFormat('jpeg');
                            $imagick->setImageCompression(Imagick::COMPRESSION_JPEG);
                            $imagick->setImageCompressionQuality(80);
                            $imagick->thumbnailImage(1280, 1280, false, false);
                            file_put_contents($targetFile, $imagick);
                            $this->CdcIssue->CdcImage->create();
                            $this->CdcIssue->CdcImage->save(array('CdcImage' => $img));
                        }
                    }
                }
                $this->Session->setFlash('資料已經儲存');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('執行時發生錯誤，請重試');
            }
        }
        $this->set('areas', $this->CdcIssue->Area->find('list', array(
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
            $dbCdcIssue = $this->CdcIssue->find('first', array(
                'conditions' => array(
                    'CdcIssue.id' => $id,
                ),
                'contain' => array(
                    'CdcImage'
                ),
            ));
        }
        if (empty($dbCdcIssue)) {
            $this->Session->setFlash('請依照網頁指示操作');
            $this->redirect($this->referer());
        }
        if (!empty($this->data)) {
            $dataToSave = $this->data;
            $this->CdcIssue->id = $id;
            $dataToSave['CdcIssue']['modified_by'] = Configure::read('loginMember.id');
            if ($this->CdcIssue->save($dataToSave)) {
                if (!empty($dataToSave['CdcImage']['file'][0]['size'])) {
                    foreach ($dataToSave['CdcImage']['file'] AS $f) {
                        if (!empty($f['size'])) {
                            $img = array(
                                'cdc_issue_id' => $id,
                                'file' => CakeText::uuid() . '.jpg',
                                'created_by' => $dataToSave['CdcIssue']['modified_by'],
                            );
                            $targetFile = WWW_ROOT . 'uploads/' . $img['file'];
                            $imagick = new Imagick($f['tmp_name']);
                            $imagick->setImageFormat('jpeg');
                            $imagick->setImageCompression(Imagick::COMPRESSION_JPEG);
                            $imagick->setImageCompressionQuality(80);
                            $imagick->thumbnailImage(1280, 1280, false, false);
                            file_put_contents($targetFile, $imagick);
                            $this->CdcIssue->CdcImage->create();
                            $this->CdcIssue->CdcImage->save(array('CdcImage' => $img));
                        }
                    }
                }
                if (!empty($dataToSave['CdcImage']['delete'])) {
                    foreach ($dataToSave['CdcImage']['delete'] AS $imgId) {
                        $imgDb = $this->CdcIssue->CdcImage->read(null, $imgId);
                        if (!empty($imgDb)) {
                            @unlink(WWW_ROOT . 'uploads/' . $imgDb['CdcImage']['file']);
                            $this->CdcIssue->CdcImage->delete($imgId);
                        }
                    }
                }
                $this->Session->setFlash('資料已經儲存');
                $this->redirect('/admin/cdc_issues/index');
            } else {
                $this->Session->setFlash('執行時發生錯誤，請重試');
            }
        }
        $this->data = $dbCdcIssue;
        $this->set('areas', $this->CdcIssue->Area->find('list', array(
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
            $dbCdcIssue = $this->CdcIssue->find('first', array(
                'conditions' => array(
                    'CdcIssue.id' => $id,
                ),
                'contain' => array(
                    'CdcImage',
                ),
            ));
        }
        if (empty($dbCdcIssue)) {
            $this->Session->setFlash('請依照網頁指示操作');
            $this->redirect('/');
        } else if ($this->CdcIssue->delete($id)) {
            foreach ($dbCdcIssue['CdcImage'] AS $img) {
                @unlink(WWW_ROOT . 'uploads/' . $img['file']);
                $this->CdcIssue->CdcImage->delete($img['id']);
            }
            $this->Session->setFlash('資料已經刪除');
            $this->redirect('/admin/cdc_issues/index');
        }
    }

    public function admin_bureau_index() {
        $loginMember = Configure::read('loginMember');
        $areas = $this->CdcIssue->Area->find('list', array(
            'fields' => array('Area.id', 'Area.id'),
            'conditions' => array('Area.parent_id' => $loginMember['area_id']),
        ));
        $this->paginate['CdcIssue'] = array(
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
        $items = $this->paginate($this->CdcIssue, array('CdcIssue.area_id' => $areas));
        $this->set('items', $items);
    }

    function admin_bureau_edit($id = null) {
        $id = intval($id);
        if ($id > 0) {
            $loginMember = Configure::read('loginMember');
            $areas = $this->CdcIssue->Area->find('list', array(
                'fields' => array('Area.id', 'Area.id'),
                'conditions' => array('Area.parent_id' => $loginMember['area_id']),
            ));
            $dbCdcIssue = $this->CdcIssue->find('first', array(
                'conditions' => array(
                    'CdcIssue.id' => $id,
                    'CdcIssue.area_id' => $areas,
                ),
                'contain' => array(
                    'CdcImage',
                    'Area' => array(
                        'Parent'
                    ),
                ),
            ));
        }
        if (empty($dbCdcIssue)) {
            $this->Session->setFlash('請依照網頁指示操作');
            $this->redirect('/');
        }
        if (!empty($this->data)) {
            $dataToSave = $this->data;
            $this->CdcIssue->id = $id;
            $dataToSave['CdcIssue']['modified_by'] = Configure::read('loginMember.id');
            if ($this->CdcIssue->save($dataToSave)) {
                if (!empty($dataToSave['CdcImage']['file'][0]['size'])) {
                    foreach ($dataToSave['CdcImage']['file'] AS $f) {
                        if (!empty($f['size'])) {
                            $img = array(
                                'cdc_issue_id' => $id,
                                'file' => CakeText::uuid() . '.jpg',
                                'created_by' => $dataToSave['CdcIssue']['modified_by'],
                            );
                            $targetFile = WWW_ROOT . 'uploads/' . $img['file'];
                            $imagick = new Imagick($f['tmp_name']);
                            $imagick->setImageFormat('jpeg');
                            $imagick->setImageCompression(Imagick::COMPRESSION_JPEG);
                            $imagick->setImageCompressionQuality(80);
                            $imagick->thumbnailImage(1280, 1280, false, false);
                            file_put_contents($targetFile, $imagick);
                            $this->CdcIssue->CdcImage->create();
                            $this->CdcIssue->CdcImage->save(array('CdcImage' => $img));
                        }
                    }
                }
                if (!empty($dataToSave['CdcImage']['delete'])) {
                    foreach ($dataToSave['CdcImage']['delete'] AS $imgId) {
                        $imgDb = $this->CdcIssue->CdcImage->read(null, $imgId);
                        if (!empty($imgDb)) {
                            @unlink(WWW_ROOT . 'uploads/' . $imgDb['CdcImage']['file']);
                            $this->CdcIssue->CdcImage->delete($imgId);
                        }
                    }
                }
                $this->Session->setFlash('資料已經儲存');
                $this->redirect('/admin/cdc_issues/bureau_index');
            } else {
                $this->Session->setFlash('執行時發生錯誤，請重試');
            }
        }
        $this->data = $dbCdcIssue;
        $this->set('areas', $this->CdcIssue->Area->find('list', array(
                    'conditions' => array(
                        'Area.parent_id IS NULL'
                    ),
                    'order' => array(
                        'Area.code' => 'DESC'
                    ),
        )));
    }

}
