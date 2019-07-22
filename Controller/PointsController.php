<?php

App::uses('AppController', 'Controller');

class PointsController extends AppController {

    public $name = 'Points';
    public $paginate = array();
    public $helpers = array('Olc');
    
    public function beforeFilter() {
        parent::beforeFilter();
        if (isset($this->Auth)) {
            $this->Auth->allow('json');
        }
    }
    
    /*
     * $pointType
     * 
     */
    public function json($pointType = null) {
        $this->layout = 'ajax';
        $result = array(
            'type' => 'FeatureCollection',
            'features' => array(),
        );
        switch($pointType) {
            case 'issues':
                $issues = $this->Point->Issue->find('all', array(
                    'conditions' => array(
                        'Issue.confirmed IS NULL'
                    ),
                    'fields' => array('label', 'reported', 'cunli', 'longitude', 'latitude', 'igm', 'igg'),
                ));
                foreach($issues AS $issue) {
                    $result['features'][] = array(
                        'type' => 'Feature',
                        'properties' => $issue['Issue'],
                        'geometry' => array(
                            'type' => 'Point',
                            'coordinates' => array(
                                floatval($issue['Issue']['longitude']),
                                floatval($issue['Issue']['latitude'])
                            ),
                        ),
                    );
                }
                break;
            case 'cases':
                $issues = $this->Point->Issue->find('all', array(
                    'conditions' => array(
                        'Issue.confirmed IS NOT NULL'
                    ),
                    'fields' => array('label', 'reported', 'cunli', 'longitude', 'latitude', 'igm', 'igg'),
                ));
                foreach($issues AS $issue) {
                    $result['features'][] = array(
                        'type' => 'Feature',
                        'properties' => $issue['Issue'],
                        'geometry' => array(
                            'type' => 'Point',
                            'coordinates' => array(
                                floatval($issue['Issue']['longitude']),
                                floatval($issue['Issue']['latitude'])
                            ),
                        ),
                    );
                }
                break;
            case 'work':
                $issues = $this->Point->find('all', array(
                    'conditions' => array(
                        'Issue.confirmed IS NOT NULL',
                        'Point.point_type' => 1,
                    ),
                    'contain' => array(
                        'Issue' => array(
                            'fields' => array('label', 'reported', 'cunli', 'longitude', 'latitude', 'igm', 'igg')
                        )
                    ),
                ));
                foreach($issues AS $issue) {
                    $result['features'][] = array(
                        'type' => 'Feature',
                        'properties' => $issue['Issue'],
                        'geometry' => array(
                            'type' => 'Point',
                            'coordinates' => array(
                                floatval($issue['Issue']['longitude']),
                                floatval($issue['Issue']['latitude'])
                            ),
                        ),
                    );
                }
                break;
            case 'activity':
                $issues = $this->Point->find('all', array(
                    'conditions' => array(
                        'Issue.confirmed IS NOT NULL',
                        'Point.point_type' => 2,
                    ),
                    'contain' => array(
                        'Issue' => array(
                            'fields' => array('label', 'reported', 'cunli', 'longitude', 'latitude', 'igm', 'igg')
                        )
                    ),
                ));
                foreach($issues AS $issue) {
                    $result['features'][] = array(
                        'type' => 'Feature',
                        'properties' => $issue['Issue'],
                        'geometry' => array(
                            'type' => 'Point',
                            'coordinates' => array(
                                floatval($issue['Issue']['longitude']),
                                floatval($issue['Issue']['latitude'])
                            ),
                        ),
                    );
                }
                break;
        }
        $this->set('result', $result);
    }

    function admin_add($issueId = null) {
        $issueId = intval($issueId);
        if ($issueId > 0) {
            $issue = $this->Point->Issue->read(null, $issueId);
        }
        if (empty($issue)) {
            $this->Session->setFlash('請依照網頁指示操作');
            $this->redirect('/');
        }
        if (!empty($this->data)) {
            $this->Point->create();
            $dataToSave = $this->data;
            $dataToSave['Point']['Issue_id'] = $issueId;
            if ($this->Point->save($dataToSave)) {
                $this->Session->setFlash('資料已經儲存');
                $this->redirect(array('controller' => 'issues', 'action' => 'view', $issueId));
            } else {
                $this->Session->setFlash('執行時發生錯誤，請重試');
            }
        }
        $this->set('issue', $issue);
    }

    function admin_edit($id = null) {
        $id = intval($id);
        if ($id > 0) {
            $dbPoint = $this->Point->find('first', array(
                'conditions' => array(
                    'Point.id' => $id,
                ),
                'contain' => array('Issue'),
            ));
        }
        if (empty($dbPoint)) {
            $this->Session->setFlash('請依照網頁指示操作');
            $this->redirect($this->referer());
        }
        if (!empty($this->data)) {
            $this->Point->id = $id;
            if ($this->Point->save($this->data)) {
                $this->Session->setFlash('資料已經儲存');
                $this->redirect('/admin/issues/view/' . $dbPoint['Issue']['id']);
            } else {
                $this->Session->setFlash('執行時發生錯誤，請重試');
            }
        }
        $this->set('id', $id);
        $this->data = $dbPoint;
    }

    function admin_delete($id = null) {
        $id = intval($id);
        if ($id > 0) {
            $dbPoint = $this->Point->find('first', array(
                'conditions' => array(
                    'Point.id' => $id,
                ),
            ));
        }
        if (empty($dbPoint)) {
            $this->Session->setFlash('請依照網頁指示操作');
            $this->redirect('/');
        } else if ($this->Point->delete($id)) {
            $this->Session->setFlash('資料已經刪除');
            $this->redirect('/admin/issues/view/' . $dbPoint['Point']['Issue_id']);
        }
    }

}
