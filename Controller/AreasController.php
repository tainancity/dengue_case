<?php

App::uses('AppController', 'Controller');

class AreasController extends AppController {

    public $name = 'Areas';
    public $paginate = array();

    public function beforeFilter() {
        parent::beforeFilter();
        if (isset($this->Auth)) {
            $this->Auth->allow(array('cunli'));
        }
    }
    
    function chemicals_delete($id = null) {
        if (!$id) {
            $this->Session->setFlash('請依照網頁指示操作');
        } else if ($this->Area->Chemical->delete($id)) {
            $this->Session->setFlash('資料已經刪除');
        }
        $this->redirect(array('action' => 'chemicals_list'));
    }

    function chemicals_list() {
        $this->paginate['Chemical'] = array(
            'limit' => 20,
            'contain' => array(
                'MemberModified' => array('fields' => 'username'),
            ),
            'order' => array(
                'modified' => 'DESC'
            ),
        );
        $items = $this->paginate($this->Area->Chemical);
        foreach ($items AS $k => $v) {
            $items[$k]['Area'] = array(
                'name' => implode('', Set::extract('{n}.Area.name', $this->Area->getPath($v['Chemical']['area_id'], array('name')))),
            );
        }
        $this->set('items', $items);
    }

    public function chemicals() {
        if (empty($this->data)) {
            $this->data = array(
                'Chemical' => array(
                    'the_date' => date('Y-m-d')
                ),
            );
        } else {
            $savingCount = 0;
            foreach ($this->data['Chemical']['area_id'] AS $k => $v) {
                $dataToSave = array(
                    'Chemical' => array(
                        'the_date' => $this->data['Chemical']['the_date'],
                        'area_id' => $v,
                        'trips' => $this->data['Chemical']['trips'][$k],
                        'door_count' => $this->data['Chemical']['door_count'][$k],
                        'door_done' => $this->data['Chemical']['door_done'][$k],
                        'fine' => $this->data['Chemical']['fine'][$k],
                        'people' => $this->data['Chemical']['people'][$k],
                        'i_water' => $this->data['Chemical']['i_water'][$k],
                        'i_positive' => $this->data['Chemical']['i_positive'][$k],
                        'o_water' => $this->data['Chemical']['o_water'][$k],
                        'o_positive' => $this->data['Chemical']['o_positive'][$k],
                        'note' => $this->data['Chemical']['note'][$k],
                    ),
                );
                $theId = $this->Area->Chemical->field('id', array(
                    'the_date' => $dataToSave['Chemical']['the_date'],
                    'area_id' => $dataToSave['Chemical']['area_id'],
                ));
                if (empty($theId)) {
                    $this->Area->Chemical->create();
                    $dataToSave['Chemical']['created_by'] = $dataToSave['Chemical']['modified_by'] = Configure::read('loginMember.id');
                } else {
                    $this->Area->Chemical->id = $theId;
                    $dataToSave['Chemical']['modified_by'] = Configure::read('loginMember.id');
                }
                if ($this->Area->Chemical->save($dataToSave)) {
                    ++$savingCount;
                }
            }
            $this->Session->setFlash("已經儲存了 {$savingCount} 筆資料");
            $this->redirect(array('action' => 'chemicals_list'));
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

    public function bureau_sources_list() {
        $this->loadModel('BureauSource');
        $this->paginate['BureauSource'] = array(
            'limit' => 20,
            'contain' => array(
                'MemberModified' => array('fields' => array('username')),
            ),
            'order' => array(
                'modified' => 'DESC'
            ),
        );
        $items = $this->paginate($this->BureauSource);
        $this->set('items', $items);
    }
    
    public function bureau_sources_delete($id = null) {
        $this->loadModel('BureauSource');
        if (!$id) {
            $this->Session->setFlash('請依照網頁指示操作');
        } else if ($this->BureauSource->delete($id)) {
            $this->Session->setFlash('資料已經刪除');
        }
        $this->redirect(array('action' => 'bureau_sources_list'));
    }
    
    public function bureau_sources() {
        $this->loadModel('BureauSource');
        if (empty($this->data)) {
            $this->data = array(
                'BureauSource' => array(
                    'the_date' => date('Y-m-d'),
                    'investigate' => 0,
                    'i_water' => 0,
                    'i_positive' => 0,
                    'o_water' => 0,
                    'o_positive' => 0,
                    'positive_done' => 0,
                    'education' => 0,
                    'people' => 0,
                ),
            );
        } else {
            $dataToSave = $this->data;
            $educationId = $this->BureauSource->field('id', array(
                'the_date' => $dataToSave['BureauSource']['the_date'],
                'unit' => $dataToSave['BureauSource']['unit'],
            ));
            if (empty($educationId)) {
                $this->BureauSource->create();
                $dataToSave['BureauSource']['created_by'] = $dataToSave['BureauSource']['modified_by'] = Configure::read('loginMember.id');
            } else {
                $this->BureauSource->id = $educationId;
                $dataToSave['BureauSource']['modified_by'] = Configure::read('loginMember.id');
            }
            $this->BureauSource->save($dataToSave);
            $this->Session->setFlash('資料已經儲存');
            $this->redirect(array('action' => 'bureau_sources_list'));
        }
    }
    
    function educations_delete($id = null) {
        if (!$id) {
            $this->Session->setFlash('請依照網頁指示操作');
        } else if ($this->Area->Education->delete($id)) {
            $this->Session->setFlash('資料已經刪除');
        }
        $this->redirect(array('action' => 'educations_list'));
    }

    function educations_list() {
        $this->paginate['Education'] = array(
            'limit' => 20,
            'contain' => array(
                'MemberModified' => array('fields' => array('username')),
                'Area' => array('fields' => array('name')),
            ),
            'order' => array(
                'modified' => 'DESC'
            ),
        );
        $items = $this->paginate($this->Area->Education);
        $this->set('items', $items);
    }

    public function educations() {
        $this->set('areas', $this->Area->find('list', array(
                    'conditions' => array(
                        'Area.parent_id IS NULL'
                    ),
                    'fields' => array('id', 'name'),
                    'order' => array(
                        'Area.code' => 'DESC'
                    ),
        )));
        if (empty($this->data)) {
            $this->data = array(
                'Education' => array(
                    'the_date' => date('Y-m-d'),
                    'education' => 0,
                ),
            );
        } else {
            $dataToSave = $this->data;
            $educationId = $this->Area->Education->field('id', array(
                'the_date' => $dataToSave['Education']['the_date'],
                'area_id' => $dataToSave['Education']['area_id'],
                'unit' => $dataToSave['Education']['unit'],
            ));
            if (empty($educationId)) {
                $this->Area->Education->create();
                $dataToSave['Education']['created_by'] = $dataToSave['Education']['modified_by'] = Configure::read('loginMember.id');
            } else {
                $this->Area->Education->id = $educationId;
                $dataToSave['Education']['modified_by'] = Configure::read('loginMember.id');
            }
            $this->Area->Education->save($dataToSave);
            $this->Session->setFlash('資料已經儲存');
            $this->redirect(array('action' => 'educations_list'));
        }
    }

    function volunteer_sources_delete($id = null) {
        if (!$id) {
            $this->Session->setFlash('請依照網頁指示操作');
        } else if ($this->Area->Education->delete($id)) {
            $this->Session->setFlash('資料已經刪除');
        }
        $this->redirect(array('action' => 'volunteer_sources_list'));
    }

    function volunteer_sources_list() {
        $this->paginate['Education'] = array(
            'limit' => 20,
            'contain' => array(
                'MemberModified' => array('fields' => 'username'),
            ),
            'order' => array(
                'modified' => 'DESC'
            ),
        );
        $items = $this->paginate($this->Area->Education);
        foreach ($items AS $k => $v) {
            $items[$k]['Area'] = array(
                'name' => implode('', Set::extract('{n}.Area.name', $this->Area->getPath($v['Education']['area_id'], array('name')))),
            );
        }
        $this->set('items', $items);
    }

    public function volunteer_sources() {
        if (empty($this->data)) {
            $this->data = array(
                'Education' => array(
                    'the_date' => date('Y-m-d')
                ),
            );
        } else {
            $savingCount = 0;
            foreach ($this->data['Education']['area_id'] AS $k => $v) {
                $dataToSave = array(
                    'Education' => array(
                        'the_date' => $this->data['Education']['the_date'],
                        'area_id' => $v,
                        'investigate' => $this->data['Education']['investigate'][$k],
                        'i_water' => $this->data['Education']['i_water'][$k],
                        'i_positive' => $this->data['Education']['i_positive'][$k],
                        'o_water' => $this->data['Education']['o_water'][$k],
                        'o_positive' => $this->data['Education']['o_positive'][$k],
                        'positive_done' => $this->data['Education']['positive_done'][$k],
                        'people' => $this->data['Education']['people'][$k],
                        'note' => $this->data['Education']['note'][$k],
                    ),
                );
                $theId = $this->Area->Education->field('id', array(
                    'the_date' => $dataToSave['Education']['the_date'],
                    'area_id' => $dataToSave['Education']['area_id'],
                ));
                if (empty($theId)) {
                    $this->Area->Education->create();
                    $dataToSave['Education']['created_by'] = $dataToSave['Education']['modified_by'] = Configure::read('loginMember.id');
                } else {
                    $this->Area->Education->id = $theId;
                    $dataToSave['Education']['modified_by'] = Configure::read('loginMember.id');
                }
                if ($this->Area->Education->save($dataToSave)) {
                    ++$savingCount;
                }
            }
            $this->Session->setFlash("已經儲存了 {$savingCount} 筆資料");
            $this->redirect(array('action' => 'volunteer_sources_list'));
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

    function area_sources_delete($id = null) {
        if (!$id) {
            $this->Session->setFlash('請依照網頁指示操作');
        } else if ($this->Area->AreaSource->delete($id)) {
            $this->Session->setFlash('資料已經刪除');
        }
        $this->redirect(array('action' => 'area_sources_list'));
    }

    function area_sources_list() {
        $this->paginate['AreaSource'] = array(
            'limit' => 20,
            'contain' => array(
                'MemberModified' => array('fields' => 'username'),
            ),
            'order' => array(
                'modified' => 'DESC'
            ),
        );
        $items = $this->paginate($this->Area->AreaSource);
        foreach ($items AS $k => $v) {
            $items[$k]['Area'] = array(
                'name' => implode('', Set::extract('{n}.Area.name', $this->Area->getPath($v['AreaSource']['area_id'], array('name')))),
            );
        }
        $this->set('items', $items);
    }

    public function area_sources() {
        if (empty($this->data)) {
            $this->data = array(
                'AreaSource' => array(
                    'the_date' => date('Y-m-d')
                ),
            );
        } else {
            $savingCount = 0;
            foreach ($this->data['AreaSource']['area_id'] AS $k => $v) {
                $dataToSave = array(
                    'AreaSource' => array(
                        'the_date' => $this->data['AreaSource']['the_date'],
                        'area_id' => $v,
                        'investigate' => $this->data['AreaSource']['investigate'][$k],
                        'i_water' => $this->data['AreaSource']['i_water'][$k],
                        'i_positive' => $this->data['AreaSource']['i_positive'][$k],
                        'o_water' => $this->data['AreaSource']['o_water'][$k],
                        'o_positive' => $this->data['AreaSource']['o_positive'][$k],
                        'positive_done' => $this->data['AreaSource']['positive_done'][$k],
                        'people' => $this->data['AreaSource']['people'][$k],
                        'note' => $this->data['AreaSource']['note'][$k],
                    ),
                );
                $theId = $this->Area->AreaSource->field('id', array(
                    'the_date' => $dataToSave['AreaSource']['the_date'],
                    'area_id' => $dataToSave['AreaSource']['area_id'],
                ));
                if (empty($theId)) {
                    $this->Area->AreaSource->create();
                    $dataToSave['AreaSource']['created_by'] = $dataToSave['AreaSource']['modified_by'] = Configure::read('loginMember.id');
                } else {
                    $this->Area->AreaSource->id = $theId;
                    $dataToSave['AreaSource']['modified_by'] = Configure::read('loginMember.id');
                }
                if ($this->Area->AreaSource->save($dataToSave)) {
                    ++$savingCount;
                }
            }
            $this->Session->setFlash("已經儲存了 {$savingCount} 筆資料");
            $this->redirect(array('action' => 'area_sources_list'));
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

    function center_sources_delete($id = null) {
        if (!$id) {
            $this->Session->setFlash('請依照網頁指示操作');
        } else if ($this->Area->CenterSource->delete($id)) {
            $this->Session->setFlash('資料已經刪除');
        }
        $this->redirect(array('action' => 'center_sources_list'));
    }

    function center_sources_list() {
        $this->paginate['CenterSource'] = array(
            'limit' => 20,
            'contain' => array(
                'MemberModified' => array('fields' => 'username'),
            ),
            'order' => array(
                'modified' => 'DESC'
            ),
        );
        $items = $this->paginate($this->Area->CenterSource);
        foreach ($items AS $k => $v) {
            $items[$k]['Area'] = array(
                'name' => implode('', Set::extract('{n}.Area.name', $this->Area->getPath($v['CenterSource']['area_id'], array('name')))),
            );
        }
        $this->set('items', $items);
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
            $this->redirect(array('action' => 'center_sources_list'));
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
