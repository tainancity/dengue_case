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

    public function report($theDate = '') {
        Configure::write('skipMemberControl', true);
        if (empty($theDate)) {
            $theDate = date('Y-m-d');
        }
        $this->loadModel('DailyCase');
        $this->set('dailyCase', $this->DailyCase->find('first', array(
                    'conditions' => array(
                        'DailyCase.the_date' => $theDate,
                    ),
        )));
        $this->set('clinicReports', $this->Area->ClinicReport->find('all', array(
                    'conditions' => array(
                        'ClinicReport.the_date' => $theDate,
                    ),
                    'contain' => array(
                        'Area' => array(
                            'fields' => array('name'),
                        )
                    ),
                    'order' => array(
                        'Area.code' => 'DESC'
                    ),
        )));
        $this->set('feverMonitors', $this->Area->FeverMonitor->find('all', array(
                    'conditions' => array(
                        'FeverMonitor.the_date' => $theDate,
                    ),
                    'contain' => array(
                        'Area' => array(
                            'fields' => array('name'),
                        )
                    ),
                    'order' => array(
                        'Area.code' => 'DESC'
                    ),
        )));
        $this->loadModel('BureauSource');
        $this->set('bureauSources', $this->BureauSource->find('all', array(
                    'conditions' => array(
                        'BureauSource.the_date' => $theDate,
                    ),
        )));
        $this->set('educations', $this->Area->Education->find('all', array(
                    'conditions' => array(
                        'Education.the_date' => $theDate,
                    ),
                    'contain' => array(
                        'Area' => array(
                            'fields' => array('name'),
                        )
                    ),
                    'order' => array(
                        'Area.code' => 'DESC'
                    ),
        )));
        $this->set('chemicals', $this->Area->Chemical->find('all', array(
                    'conditions' => array(
                        'Chemical.the_date' => $theDate,
                    ),
                    'contain' => array(
                        'Area' => array(
                            'fields' => array('name'),
                            'Parent' => array(
                                'fields' => array('name'),
                            ),
                        )
                    ),
                    'order' => array(
                        'Area.code' => 'DESC'
                    ),
        )));
        $this->set('volunteerSources', $this->Area->VolunteerSource->find('all', array(
                    'conditions' => array(
                        'VolunteerSource.the_date' => $theDate,
                    ),
                    'contain' => array(
                        'Area' => array(
                            'fields' => array('name'),
                            'Parent' => array(
                                'fields' => array('name'),
                            ),
                        )
                    ),
                    'order' => array(
                        'Area.code' => 'DESC'
                    ),
        )));
        $this->set('areaSources', $this->Area->AreaSource->find('all', array(
                    'conditions' => array(
                        'AreaSource.the_date' => $theDate,
                    ),
                    'contain' => array(
                        'Area' => array(
                            'fields' => array('name'),
                            'Parent' => array(
                                'fields' => array('name'),
                            ),
                        )
                    ),
                    'order' => array(
                        'Area.code' => 'DESC'
                    ),
        )));
        $this->set('centerSources', $this->Area->CenterSource->find('all', array(
                    'conditions' => array(
                        'CenterSource.the_date' => $theDate,
                    ),
                    'contain' => array(
                        'Area' => array(
                            'fields' => array('name'),
                            'Parent' => array(
                                'fields' => array('name'),
                            ),
                        )
                    ),
                    'order' => array(
                        'Area.code' => 'DESC'
                    ),
        )));
        $this->set('expands', $this->Area->Expand->find('all', array(
                    'conditions' => array(
                        'Expand.the_date' => $theDate,
                    ),
                    'contain' => array(
                        'Area' => array(
                            'fields' => array('name'),
                        )
                    ),
                    'order' => array(
                        'Area.code' => 'DESC'
                    ),
        )));
        $this->set('fevers', $this->Area->Fever->find('all', array(
                    'conditions' => array(
                        'Fever.the_date' => $theDate,
                    ),
                    'contain' => array(
                        'Area' => array(
                            'fields' => array('name'),
                        )
                    ),
                    'order' => array(
                        'Area.code' => 'DESC'
                    ),
        )));
        $this->set('tracks', $this->Area->Track->find('all', array(
                    'conditions' => array(
                        'Track.the_date' => $theDate,
                    ),
                    'contain' => array(
                        'Area' => array(
                            'fields' => array('name'),
                        )
                    ),
                    'order' => array(
                        'Area.code' => 'DESC'
                    ),
        )));
        $this->set('theDate', $theDate);
        Configure::write('skipMemberControl', false);
    }

    public function clinic_reports_list() {
        $this->paginate['ClinicReport'] = array(
            'limit' => 20,
            'contain' => array(
                'MemberModified' => array('fields' => array('username')),
                'Area' => array('fields' => array('name')),
            ),
            'order' => array(
                'modified' => 'DESC'
            ),
        );
        $items = $this->paginate($this->Area->ClinicReport);
        $this->set('items', $items);
    }

    public function health_add() {
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
                'Education' => array(
                    'education' => 0,
                ),
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
            $selectedDate = $dataToSave['Expand']['the_date'];
            $dataToSave['Fever']['the_date'] = $selectedDate;
            $dataToSave['Fever']['area_id'] = $dataToSave['Expand']['area_id'];
            $dataToSave['Track']['the_date'] = $selectedDate;
            $dataToSave['Track']['area_id'] = $dataToSave['Expand']['area_id'];
            $dataToSave['Education']['the_date'] = $selectedDate;
            $dataToSave['Education']['area_id'] = $dataToSave['Expand']['area_id'];
            $dataToSave['Education']['unit'] = '衛生所';

            $expandId = $this->Area->Expand->field('id', array(
                'the_date' => $selectedDate,
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

            $feverId = $this->Area->Fever->field('id', array(
                'the_date' => $selectedDate,
                'area_id' => $dataToSave['Fever']['area_id'],
            ));
            if (empty($feverId)) {
                $this->Area->Fever->create();
            } else {
                $this->Area->Fever->id = $feverId;
            }
            $this->Area->Fever->save($dataToSave);

            $trackId = $this->Area->Track->field('id', array(
                'the_date' => $selectedDate,
                'area_id' => $dataToSave['Track']['area_id'],
            ));
            if (empty($trackId)) {
                $this->Area->Track->create();
            } else {
                $this->Area->Track->id = $trackId;
            }
            $this->Area->Track->save($dataToSave);

            $savingCount = 0;
            foreach ($this->data['CenterSource']['area_id'] AS $k => $v) {
                $dataToSave = array(
                    'CenterSource' => array(
                        'the_date' => $selectedDate,
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
                    'the_date' => $selectedDate,
                    'area_id' => $dataToSave['CenterSource']['area_id'],
                ));
                if (empty($theId)) {
                    $this->Area->CenterSource->create();
                    $dataToSave['CenterSource']['created_by'] = $dataToSave['CenterSource']['modified_by'] = Configure::read('loginMember.id');
                } else {
                    $this->Area->CenterSource->id = $theId;
                    $dataToSave['CenterSource']['modified_by'] = Configure::read('loginMember.id');
                }
                $this->Area->CenterSource->save($dataToSave);
            }
            $this->redirect(array('action' => 'health_list'));
        }
    }

    public function health_edit($expandId = 0) {
        $expandId = intval($expandId);
        if ($expandId > 0) {
            $expand = $this->Area->Expand->find('first', array(
                'conditions' => array(
                    'Expand.id' => $expandId,
                ),
                'contain' => array(
                    'Area' => array(
                        'fields' => array('name'),
                    ),
                ),
            ));
        }
        if (!empty($expand)) {
            $cunlis = $this->Area->find('list', array(
                'conditions' => array(
                    'Area.parent_id' => $expand['Expand']['area_id'],
                ),
                'fields' => array('Area.id', 'Area.name'),
            ));
            $education = $this->Area->Education->find('first', array(
                'conditions' => array(
                    'the_date' => $expand['Expand']['the_date'],
                    'area_id' => $expand['Expand']['area_id'],
                    'unit' => '衛生所',
                ),
            ));
            if(empty($education)) {
                $education = array(
                    'Education' => array(
                        'education' => 0,
                    ),
                );
            }
            $fever = $this->Area->Fever->find('first', array(
                'conditions' => array(
                    'the_date' => $expand['Expand']['the_date'],
                    'area_id' => $expand['Expand']['area_id'],
                ),
            ));
            $track = $this->Area->Track->find('first', array(
                'conditions' => array(
                    'the_date' => $expand['Expand']['the_date'],
                    'area_id' => $expand['Expand']['area_id'],
                ),
            ));
            $centerSources = $this->Area->CenterSource->find('all', array(
                'conditions' => array(
                    'the_date' => $expand['Expand']['the_date'],
                    'area_id' => array_keys($cunlis),
                ),
            ));
            if(empty($centerSources)) {
                $centerSources = array(
                    array('CenterSource' => array(
                        'id' => 0,
                        'investigate' => 0,
                        'i_water' => 0,
                        'o_water' => 0,
                        'i_positive' => 0,
                        'o_positive' => 0,
                        'positive_done' => 0,
                        'people' => 0,
                        'fine' => 0,
                        'note' => '',
                    ))
                );
            }

            if (empty($this->data)) {
                $this->data = array(
                    'Expand' => $expand['Expand'],
                    'Education' => $education['Education'],
                    'Fever' => $fever['Fever'],
                    'Track' => $track['Track'],
                );
            } else {
                $dataToSave = $this->data;
                $this->Area->Expand->id = $dataToSave['Expand']['id'];
                $dataToSave['Expand']['modified_by'] = Configure::read('loginMember.id');
                $this->Area->Expand->save($dataToSave);
                $this->Area->Fever->id = $dataToSave['Fever']['id'];
                $dataToSave['Fever']['modified_by'] = Configure::read('loginMember.id');
                $this->Area->Fever->save($dataToSave);
                $this->Area->Track->id = $dataToSave['Track']['id'];
                $dataToSave['Track']['modified_by'] = Configure::read('loginMember.id');
                $this->Area->Track->save($dataToSave);
                $this->Area->Education->id = $dataToSave['Education']['id'];
                if(empty($dataToSave['Education']['id'])) {
                    $dataToSave['Education']['the_date'] = $expand['Expand']['the_date'];
                    $dataToSave['Education']['area_id'] = $expand['Expand']['area_id'];
                    $dataToSave['Education']['unit'] = '衛生所';
                    $dataToSave['Education']['created_by'] = Configure::read('loginMember.id');
                }
                $dataToSave['Education']['modified_by'] = Configure::read('loginMember.id');
                $this->Area->Education->save($dataToSave);
                $areaIdPool = array();
                foreach ($dataToSave['CenterSource']['id'] AS $key => $id) {
                    if (isset($dataToSave['CenterSource']['delete']) && in_array($id, $dataToSave['CenterSource']['delete'])) {
                        $this->Area->CenterSource->delete($id);
                    } else {
                        if (isset($areaIdPool[$dataToSave['CenterSource']['area_id'][$key]])) {
                            $theId = $areaIdPool[$dataToSave['CenterSource']['area_id'][$key]];
                        } else {
                            $theId = $this->Area->CenterSource->field('id', array(
                                'the_date' => $expand['Expand']['the_date'],
                                'area_id' => $dataToSave['CenterSource']['area_id'][$key],
                            ));
                        }
                        $centerSource = array('CenterSource' => array(
                                'the_date' => $expand['Expand']['the_date'],
                                'area_id' => $dataToSave['CenterSource']['area_id'][$key],
                                'investigate' => $dataToSave['CenterSource']['investigate'][$key],
                                'i_water' => $dataToSave['CenterSource']['i_water'][$key],
                                'i_positive' => $dataToSave['CenterSource']['i_positive'][$key],
                                'o_water' => $dataToSave['CenterSource']['o_water'][$key],
                                'o_positive' => $dataToSave['CenterSource']['o_positive'][$key],
                                'positive_done' => $dataToSave['CenterSource']['positive_done'][$key],
                                'fine' => $dataToSave['CenterSource']['fine'][$key],
                                'people' => $dataToSave['CenterSource']['people'][$key],
                                'note' => $dataToSave['CenterSource']['note'][$key],
                        ));
                        if (empty($theId)) {
                            $this->Area->CenterSource->create();
                            $centerSource['CenterSource']['created_by'] = $centerSource['CenterSource']['modified_by'] = Configure::read('loginMember.id');
                        } else {
                            $areaIdPool[$dataToSave['CenterSource']['area_id'][$key]] = $theId;
                            $this->Area->CenterSource->id = $theId;
                            $centerSource['CenterSource']['modified_by'] = Configure::read('loginMember.id');
                        }
                        $this->Area->CenterSource->save($centerSource);
                        if (empty($theId)) {
                            $areaIdPool[$dataToSave['CenterSource']['area_id'][$key]] = $this->Area->CenterSource->getInsertID();
                        }
                    }
                }
                $this->redirect(array('action' => 'health_list'));
            }
            $this->set('expand', $expand);
            $this->set('cunlis', $cunlis);
            $this->set('centerSources', $centerSources);
        }
    }

    public function health_delete($expandId) {
        $expandId = intval($expandId);
        if ($expandId > 0) {
            $expand = $this->Area->Expand->find('first', array(
                'conditions' => array(
                    'Expand.id' => $expandId,
                ),
            ));
            $cunlis = $this->Area->find('list', array(
                'conditions' => array(
                    'Area.parent_id' => $expand['Expand']['area_id'],
                ),
                'fields' => array('Area.id', 'Area.id'),
            ));
            $this->Area->CenterSource->deleteAll(array(
                'the_date' => $expand['Expand']['the_date'],
                'area_id' => $cunlis,
            ));
            $this->Area->Education->deleteAll(array(
                'the_date' => $expand['Expand']['the_date'],
                'area_id' => $expand['Expand']['area_id'],
                'unit' => '衛生所',
            ));
            $this->Area->Fever->deleteAll(array(
                'the_date' => $expand['Expand']['the_date'],
                'area_id' => $expand['Expand']['area_id'],
            ));
            $this->Area->Track->deleteAll(array(
                'the_date' => $expand['Expand']['the_date'],
                'area_id' => $expand['Expand']['area_id'],
            ));
            $this->Area->Expand->deleteAll(array(
                'the_date' => $expand['Expand']['the_date'],
                'area_id' => $expand['Expand']['area_id'],
            ));
        }
        $this->redirect(array('action' => 'health_list'));
    }

    public function health_list() {
        $this->paginate['Expand'] = array(
            'limit' => 20,
            'contain' => array(
                'Area' => array('fields' => array('name')),
                'MemberModified' => array('fields' => array('username')),
            ),
            'order' => array(
                'modified' => 'DESC'
            ),
        );
        $items = $this->paginate($this->Area->Expand);
        foreach ($items AS $k => $v) {
            $items[$k]['Fever'] = $this->Area->Fever->find('first', array(
                        'conditions' => array(
                            'Fever.the_date' => $v['Expand']['the_date'],
                            'Fever.area_id' => $v['Expand']['area_id'],
                        ),
                    ))['Fever'];
            $items[$k]['Track'] = $this->Area->Track->find('first', array(
                        'conditions' => array(
                            'Track.the_date' => $v['Expand']['the_date'],
                            'Track.area_id' => $v['Expand']['area_id'],
                        ),
                    ))['Track'];
        }
        $this->set('items', $items);
    }

    public function bureau_add() {
        if (empty($this->data)) {
            $this->data = array(
                'Education' => array(
                    'the_date' => date('Y-m-d'),
                    'education' => 0,
                ),
            );
        } else {
            $dataToSave = $this->data;
            $dataToSave['Education']['unit'] = '區公所';
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

            foreach ($this->data['AreaSource']['area_id'] AS $k => $v) {
                $areaSource = array(
                    'AreaSource' => array(
                        'the_date' => $dataToSave['Education']['the_date'],
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
                    'the_date' => $dataToSave['Education']['the_date'],
                    'area_id' => $areaSource['AreaSource']['area_id'],
                ));
                if (empty($theId)) {
                    $this->Area->AreaSource->create();
                    $areaSource['AreaSource']['created_by'] = $areaSource['AreaSource']['modified_by'] = Configure::read('loginMember.id');
                } else {
                    $this->Area->AreaSource->id = $theId;
                    $areaSource['AreaSource']['modified_by'] = Configure::read('loginMember.id');
                }
                $this->Area->AreaSource->save($areaSource);
            }

            foreach ($this->data['VolunteerSource']['area_id'] AS $k => $v) {
                $volunteerSource = array(
                    'VolunteerSource' => array(
                        'the_date' => $dataToSave['Education']['the_date'],
                        'area_id' => $v,
                        'investigate' => $this->data['VolunteerSource']['investigate'][$k],
                        'i_water' => $this->data['VolunteerSource']['i_water'][$k],
                        'i_positive' => $this->data['VolunteerSource']['i_positive'][$k],
                        'o_water' => $this->data['VolunteerSource']['o_water'][$k],
                        'o_positive' => $this->data['VolunteerSource']['o_positive'][$k],
                        'positive_done' => $this->data['VolunteerSource']['positive_done'][$k],
                        'people' => $this->data['VolunteerSource']['people'][$k],
                        'note' => $this->data['VolunteerSource']['note'][$k],
                    ),
                );
                $theId = $this->Area->VolunteerSource->field('id', array(
                    'the_date' => $dataToSave['Education']['the_date'],
                    'area_id' => $volunteerSource['VolunteerSource']['area_id'],
                ));
                if (empty($theId)) {
                    $this->Area->VolunteerSource->create();
                    $volunteerSource['VolunteerSource']['created_by'] = $volunteerSource['VolunteerSource']['modified_by'] = Configure::read('loginMember.id');
                } else {
                    $this->Area->VolunteerSource->id = $theId;
                    $volunteerSource['VolunteerSource']['modified_by'] = Configure::read('loginMember.id');
                }
                $this->Area->VolunteerSource->save($volunteerSource);
            }
            $this->redirect(array('action' => 'bureau_list'));
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

    public function bureau_edit($educationId = 0) {
        $educationId = intval($educationId);
        if ($educationId > 0) {
            $education = $this->Area->Education->find('first', array(
                'conditions' => array('Education.id' => $educationId),
                'contain' => array(
                    'Area' => array(
                        'fields' => array('name')
                    ),
                ),
            ));
        }
        if (!empty($education)) {
            if (empty($this->data)) {
                $cunlis = $this->Area->find('list', array(
                    'conditions' => array(
                        'Area.parent_id' => $education['Education']['area_id'],
                    ),
                    'fields' => array('Area.id', 'Area.name'),
                ));
                $areaSources = $this->Area->AreaSource->find('all', array(
                    'conditions' => array(
                        'the_date' => $education['Education']['the_date'],
                        'area_id' => array_keys($cunlis),
                    ),
                ));
                if (empty($areaSources)) {
                    $areaSources = array(
                        array('AreaSource' => array(
                                'id' => 0,
                                'area_id' => 0,
                                'investigate' => 0,
                                'i_water' => 0,
                                'i_positive' => 0,
                                'o_water' => 0,
                                'o_positive' => 0,
                                'positive_done' => 0,
                                'people' => 0,
                                'note' => '',
                            )),
                    );
                }
                $volunteerSources = $this->Area->VolunteerSource->find('all', array(
                    'conditions' => array(
                        'the_date' => $education['Education']['the_date'],
                        'area_id' => array_keys($cunlis),
                    ),
                ));
                if (empty($volunteerSources)) {
                    $volunteerSources = array(
                        array('VolunteerSource' => array(
                                'id' => 0,
                                'area_id' => 0,
                                'investigate' => 0,
                                'i_water' => 0,
                                'i_positive' => 0,
                                'o_water' => 0,
                                'o_positive' => 0,
                                'positive_done' => 0,
                                'people' => 0,
                                'note' => '',
                            ))
                    );
                }
                $this->set('education', $education);
                $this->set('cunlis', $cunlis);
                $this->set('areaSources', $areaSources);
                $this->set('volunteerSources', $volunteerSources);
            } else {
                $dataToSave = $this->data;
                $dataToSave['Education']['unit'] = '區公所';
                $educationId = $this->Area->Education->field('id', array(
                    'the_date' => $education['Education']['the_date'],
                    'area_id' => $education['Education']['area_id'],
                    'unit' => $education['Education']['unit'],
                ));
                if (empty($educationId)) {
                    $this->Area->Education->create();
                    $dataToSave['Education']['created_by'] = $dataToSave['Education']['modified_by'] = Configure::read('loginMember.id');
                } else {
                    $this->Area->Education->id = $educationId;
                    $dataToSave['Education']['modified_by'] = Configure::read('loginMember.id');
                }
                $this->Area->Education->save($dataToSave);

                foreach ($this->data['AreaSource']['id'] AS $k => $v) {
                    if (isset($this->data['AreaSource']['delete']) && in_array($v, $this->data['AreaSource']['delete'])) {
                        $this->Area->AreaSource->delete($v);
                    } else {
                        $areaSource = array(
                            'AreaSource' => array(
                                'the_date' => $education['Education']['the_date'],
                                'area_id' => $this->data['AreaSource']['area_id'][$k],
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
                            'the_date' => $education['Education']['the_date'],
                            'area_id' => $areaSource['AreaSource']['area_id'],
                        ));
                        if (empty($theId)) {
                            $this->Area->AreaSource->create();
                            $areaSource['AreaSource']['created_by'] = $areaSource['AreaSource']['modified_by'] = Configure::read('loginMember.id');
                        } else {
                            $this->Area->AreaSource->id = $theId;
                            $areaSource['AreaSource']['modified_by'] = Configure::read('loginMember.id');
                        }
                        $this->Area->AreaSource->save($areaSource);
                    }
                }

                foreach ($this->data['VolunteerSource']['id'] AS $k => $v) {
                    if (isset($this->data['VolunteerSource']['delete']) && in_array($v, $this->data['VolunteerSource']['delete'])) {
                        $this->Area->VolunteerSource->delete($v);
                    } else {
                        $volunteerSource = array(
                            'VolunteerSource' => array(
                                'the_date' => $education['Education']['the_date'],
                                'area_id' => $this->data['VolunteerSource']['area_id'][$k],
                                'investigate' => $this->data['VolunteerSource']['investigate'][$k],
                                'i_water' => $this->data['VolunteerSource']['i_water'][$k],
                                'i_positive' => $this->data['VolunteerSource']['i_positive'][$k],
                                'o_water' => $this->data['VolunteerSource']['o_water'][$k],
                                'o_positive' => $this->data['VolunteerSource']['o_positive'][$k],
                                'positive_done' => $this->data['VolunteerSource']['positive_done'][$k],
                                'people' => $this->data['VolunteerSource']['people'][$k],
                                'note' => $this->data['VolunteerSource']['note'][$k],
                            ),
                        );
                        $theId = $this->Area->VolunteerSource->field('id', array(
                            'the_date' => $education['Education']['the_date'],
                            'area_id' => $volunteerSource['VolunteerSource']['area_id'],
                        ));
                        if (empty($theId)) {
                            $this->Area->VolunteerSource->create();
                            $volunteerSource['VolunteerSource']['created_by'] = $volunteerSource['VolunteerSource']['modified_by'] = Configure::read('loginMember.id');
                        } else {
                            $this->Area->VolunteerSource->id = $theId;
                            $volunteerSource['VolunteerSource']['modified_by'] = Configure::read('loginMember.id');
                        }
                        $this->Area->VolunteerSource->save($volunteerSource);
                    }
                }
                $this->redirect(array('action' => 'bureau_list'));
            }
        } else {
            $this->Session->setFlash('請依照網頁指示操作');
            $this->redirect(array('action' => 'bureau_list'));
        }
    }

    public function bureau_delete($educationId = 0) {
        $educationId = intval($educationId);
        if ($educationId > 0) {
            $education = $this->Area->Education->find('first', array(
                'conditions' => array('Education.id' => $educationId),
            ));
        }
        if (!empty($education)) {
            $cunlis = $this->Area->find('list', array(
                'conditions' => array(
                    'Area.parent_id' => $education['Education']['area_id'],
                ),
                'fields' => array('Area.id', 'Area.id'),
            ));
            $this->Area->Education->delete($educationId);
            $this->Area->VolunteerSource->deleteAll(array(
                'the_date' => $education['Education']['the_date'],
                'area_id' => $cunlis,
            ));
            $this->Area->AreaSource->deleteAll(array(
                'the_date' => $education['Education']['the_date'],
                'area_id' => $cunlis,
            ));
        }
        $this->redirect(array('action' => 'bureau_list'));
    }

    public function bureau_list() {
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
        $items = $this->paginate($this->Area->Education, array('Education.unit' => '區公所'));
        $this->set('items', $items);
    }

    public function center_add() {
        
    }

    public function center_edit() {
        
    }

    public function center_delete() {
        
    }

    public function center_list() {
        
    }

    public function clinic_reports_delete($id = 0) {
        $id = intval($id);
        if ($id > 0) {
            $item = $this->Area->ClinicReport->read(array('id'), $id);
        }
        if (empty($item)) {
            $this->Session->setFlash('請依照網頁指示操作');
        } else if ($this->Area->ClinicReport->delete($id)) {
            $this->Session->setFlash('資料已經刪除');
        }
        $this->redirect(array('action' => 'clinic_reports_list'));
    }

    public function clinic_reports() {
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
                'ClinicReport' => array(
                    'the_date' => date('Y-m-d'),
                    'count_p' => 0,
                    'count_n' => 0,
                ),
            );
        } else {
            foreach ($this->data['ClinicReport']['area_id'] AS $k => $v) {
                $dataToSave = array('ClinicReport' => array(
                        'the_date' => $this->data['ClinicReport']['the_date'],
                        'area_id' => $this->data['ClinicReport']['area_id'][$k],
                        'count_p' => $this->data['ClinicReport']['count_p'][$k],
                        'count_n' => $this->data['ClinicReport']['count_n'][$k],
                        'note' => $this->data['ClinicReport']['note'][$k],
                ));
                $theId = $this->Area->ClinicReport->field('id', array(
                    'the_date' => $dataToSave['ClinicReport']['the_date'],
                    'area_id' => $dataToSave['ClinicReport']['area_id'],
                ));
                if (empty($theId)) {
                    $this->Area->ClinicReport->create();
                    $dataToSave['ClinicReport']['created_by'] = $dataToSave['ClinicReport']['modified_by'] = Configure::read('loginMember.id');
                } else {
                    $this->Area->ClinicReport->id = $theId;
                    $dataToSave['ClinicReport']['modified_by'] = Configure::read('loginMember.id');
                }
                $this->Area->ClinicReport->save($dataToSave);
            }
            $this->Session->setFlash('資料已經儲存');
            $this->redirect(array('action' => 'clinic_reports_list'));
        }
    }

    function fever_monitors_delete($id = 0) {
        $id = intval($id);
        if ($id > 0) {
            $item = $this->Area->FeverMonitor->read(array('id'), $id);
        }
        if (empty($item)) {
            $this->Session->setFlash('請依照網頁指示操作');
        } else if ($this->Area->FeverMonitor->delete($id)) {
            $this->Session->setFlash('資料已經刪除');
        }
        $this->redirect(array('action' => 'fever_monitors_list'));
    }

    function fever_monitors_list() {
        $this->paginate['FeverMonitor'] = array(
            'limit' => 20,
            'contain' => array(
                'MemberModified' => array('fields' => array('username')),
                'Area' => array('fields' => array('name')),
            ),
            'order' => array(
                'modified' => 'DESC'
            ),
        );
        $items = $this->paginate($this->Area->FeverMonitor);
        $this->set('items', $items);
    }

    public function fever_monitors() {
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
                'FeverMonitor' => array(
                    'the_date' => date('Y-m-d'),
                    'people_count' => 0,
                    'people_track' => 0,
                ),
            );
        } else {
            $dataToSave = $this->data;
            $theId = $this->Area->FeverMonitor->field('id', array(
                'the_date' => $dataToSave['FeverMonitor']['the_date'],
                'area_id' => $dataToSave['FeverMonitor']['area_id'],
            ));
            if (empty($theId)) {
                $this->Area->FeverMonitor->create();
                $dataToSave['FeverMonitor']['created_by'] = $dataToSave['FeverMonitor']['modified_by'] = Configure::read('loginMember.id');
            } else {
                $this->Area->FeverMonitor->id = $theId;
                $dataToSave['FeverMonitor']['modified_by'] = Configure::read('loginMember.id');
            }
            $this->Area->FeverMonitor->save($dataToSave);
            $this->Session->setFlash('資料已經儲存');
            $this->redirect(array('action' => 'fever_monitors_list'));
        }
    }

    function chemicals_delete($id = 0) {
        $id = intval($id);
        if ($id > 0) {
            $item = $this->Area->Chemical->read(array('id'), $id);
        }
        if (empty($item)) {
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

    public function daily_cases_list() {
        $this->loadModel('DailyCase');
        $this->paginate['DailyCase'] = array(
            'limit' => 20,
            'contain' => array(
                'MemberModified' => array('fields' => array('username')),
            ),
            'order' => array(
                'modified' => 'DESC'
            ),
        );
        $items = $this->paginate($this->DailyCase);
        $this->set('items', $items);
    }

    public function daily_cases_delete($id = 0) {
        $this->loadModel('DailyCase');
        $id = intval($id);
        if ($id > 0) {
            $item = $this->DailyCase->read(array('id'), $id);
        }
        if (empty($item)) {
            $this->Session->setFlash('請依照網頁指示操作');
        } else if ($this->DailyCase->delete($id)) {
            $this->Session->setFlash('資料已經刪除');
        }
        $this->redirect(array('action' => 'daily_cases_list'));
    }

    public function daily_cases() {
        $this->loadModel('DailyCase');
        if (empty($this->data)) {
            $this->data = array(
                'DailyCase' => array(
                    'the_date' => date('Y-m-d'),
                    'count_local' => 0,
                    'count_imported' => 0,
                ),
            );
        } else {
            $dataToSave = $this->data;
            $theId = $this->DailyCase->field('id', array(
                'the_date' => $dataToSave['DailyCase']['the_date'],
            ));
            if (empty($educationId)) {
                $this->DailyCase->create();
                $dataToSave['DailyCase']['created_by'] = $dataToSave['DailyCase']['modified_by'] = Configure::read('loginMember.id');
            } else {
                $this->DailyCase->id = $theId;
                $dataToSave['DailyCase']['modified_by'] = Configure::read('loginMember.id');
            }
            $this->DailyCase->save($dataToSave);
            $this->Session->setFlash('資料已經儲存');
            $this->redirect(array('action' => 'daily_cases_list'));
        }
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

    public function bureau_sources_delete($id = 0) {
        $this->loadModel('BureauSource');
        $id = intval($id);
        if ($id > 0) {
            $item = $this->BureauSource->read(array('id'), $id);
        }
        if (empty($item)) {
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

    function educations_delete($id = 0) {
        $id = intval($id);
        if ($id > 0) {
            $item = $this->Area->Education->read(array('id'), $id);
        }
        if (empty($item)) {
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

    function volunteer_sources_delete($id = 0) {
        $id = intval($id);
        if ($id > 0) {
            $item = $this->Area->VolunteerSource->read(array('id'), $id);
        }
        if (empty($item)) {
            $this->Session->setFlash('請依照網頁指示操作');
        } else if ($this->Area->VolunteerSource->delete($id)) {
            $this->Session->setFlash('資料已經刪除');
        }
        $this->redirect(array('action' => 'volunteer_sources_list'));
    }

    function volunteer_sources_list() {
        $this->paginate['VolunteerSource'] = array(
            'limit' => 20,
            'contain' => array(
                'MemberModified' => array('fields' => 'username'),
            ),
            'order' => array(
                'modified' => 'DESC'
            ),
        );
        $items = $this->paginate($this->Area->VolunteerSource);
        foreach ($items AS $k => $v) {
            $items[$k]['Area'] = array(
                'name' => implode('', Set::extract('{n}.Area.name', $this->Area->getPath($v['VolunteerSource']['area_id'], array('name')))),
            );
        }
        $this->set('items', $items);
    }

    public function volunteer_sources() {
        if (empty($this->data)) {
            $this->data = array(
                'VolunteerSource' => array(
                    'the_date' => date('Y-m-d')
                ),
            );
        } else {
            $savingCount = 0;
            foreach ($this->data['VolunteerSource']['area_id'] AS $k => $v) {
                $dataToSave = array(
                    'VolunteerSource' => array(
                        'the_date' => $this->data['VolunteerSource']['the_date'],
                        'area_id' => $v,
                        'investigate' => $this->data['VolunteerSource']['investigate'][$k],
                        'i_water' => $this->data['VolunteerSource']['i_water'][$k],
                        'i_positive' => $this->data['VolunteerSource']['i_positive'][$k],
                        'o_water' => $this->data['VolunteerSource']['o_water'][$k],
                        'o_positive' => $this->data['VolunteerSource']['o_positive'][$k],
                        'positive_done' => $this->data['VolunteerSource']['positive_done'][$k],
                        'people' => $this->data['VolunteerSource']['people'][$k],
                        'note' => $this->data['VolunteerSource']['note'][$k],
                    ),
                );
                $theId = $this->Area->VolunteerSource->field('id', array(
                    'the_date' => $dataToSave['VolunteerSource']['the_date'],
                    'area_id' => $dataToSave['VolunteerSource']['area_id'],
                ));
                if (empty($theId)) {
                    $this->Area->VolunteerSource->create();
                    $dataToSave['VolunteerSource']['created_by'] = $dataToSave['VolunteerSource']['modified_by'] = Configure::read('loginMember.id');
                } else {
                    $this->Area->VolunteerSource->id = $theId;
                    $dataToSave['VolunteerSource']['modified_by'] = Configure::read('loginMember.id');
                }
                if ($this->Area->VolunteerSource->save($dataToSave)) {
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

    function area_sources_delete($id = 0) {
        $id = intval($id);
        if ($id > 0) {
            $item = $this->Area->AreaSource->read(array('id'), $id);
        }
        if (empty($item)) {
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

    function center_sources_delete($id = 0) {
        $id = intval($id);
        if ($id > 0) {
            $item = $this->Area->CenterSource->read(array('id'), $id);
        }
        if (empty($item)) {
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

    function health_bureau_list() {
        $this->paginate['Expand'] = array(
            'limit' => 20,
            'contain' => array(
                'Area' => array('fields' => array('name')),
                'MemberModified' => array('fields' => array('username')),
            ),
            'order' => array(
                'modified' => 'DESC'
            ),
        );
        $items = $this->paginate($this->Area->Expand);
        foreach ($items AS $k => $v) {
            $items[$k]['Fever'] = $this->Area->Fever->find('first', array(
                        'conditions' => array(
                            'Fever.the_date' => $v['Expand']['the_date'],
                            'Fever.area_id' => $v['Expand']['area_id'],
                        ),
                    ))['Fever'];
            $items[$k]['Track'] = $this->Area->Track->find('first', array(
                        'conditions' => array(
                            'Track.the_date' => $v['Expand']['the_date'],
                            'Track.area_id' => $v['Expand']['area_id'],
                        ),
                    ))['Track'];
        }
        $this->set('items', $items);
    }

    public function health_bureau_delete($id = 0) {
        $id = intval($id);
        if ($id > 0) {
            $expand = $this->Area->Expand->read(null, $id);
        }
        if (!empty($expand)) {
            $this->Area->Fever->deleteAll(array(
                'Fever.the_date' => $expand['Expand']['the_date'],
                'Fever.area_id' => $expand['Expand']['area_id'],
            ));
            $this->Area->Track->deleteAll(array(
                'Track.the_date' => $expand['Expand']['the_date'],
                'Track.area_id' => $expand['Expand']['area_id'],
            ));
            $this->Area->Expand->delete($id);
            $this->Session->setFlash('資料已經刪除');
        } else {
            $this->Session->setFlash('請依照網頁指示操作');
        }
        $this->redirect(array('action' => 'health_bureau_list'));
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
            $this->redirect(array('action' => 'health_bureau_list'));
        }
    }

}
