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

}
