<?php

App::uses('AppController', 'Controller');

class CdcPointsController extends AppController {

    public $name = 'CdcPoints';
    public $paginate = array();
    public $helpers = array('Olc');

    public function beforeFilter() {
        parent::beforeFilter();
        if (isset($this->Auth)) {
            //$this->Auth->allow(array('json', 'map'));
        }
    }
    
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
