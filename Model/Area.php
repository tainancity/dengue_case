<?php

class Area extends AppModel {

    public $name = 'Area';
    public $actsAs = array('Tree');
    var $belongsTo = array(
        'Parent' => array(
            'foreignKey' => 'parent_id',
            'className' => 'Area',
        ),
    );
    var $hasMany = array(
        'Expand' => array(
            'foreignKey' => 'area_id',
            'dependent' => false,
            'className' => 'Expand',
        ),
        'Fever' => array(
            'foreignKey' => 'area_id',
            'dependent' => false,
            'className' => 'Fever',
        ),
        'Track' => array(
            'foreignKey' => 'area_id',
            'dependent' => false,
            'className' => 'Track',
        ),
        'CenterSource' => array(
            'foreignKey' => 'area_id',
            'dependent' => false,
            'className' => 'CenterSource',
        ),
        'AreaSource' => array(
            'foreignKey' => 'area_id',
            'dependent' => false,
            'className' => 'AreaSource',
        ),
        'VolunteerSource' => array(
            'foreignKey' => 'area_id',
            'dependent' => false,
            'className' => 'VolunteerSource',
        ),
        'Education' => array(
            'foreignKey' => 'area_id',
            'dependent' => false,
            'className' => 'Education',
        ),
        'Chemical' => array(
            'foreignKey' => 'area_id',
            'dependent' => false,
            'className' => 'Chemical',
        ),
        'FeverMonitor' => array(
            'foreignKey' => 'area_id',
            'dependent' => false,
            'className' => 'FeverMonitor',
        ),
        'ClinicReport' => array(
            'foreignKey' => 'area_id',
            'dependent' => false,
            'className' => 'ClinicReport',
        ),
    );

    public function csvExpand($theDate) {
        $result = array();
        $result[] = array('區別', '當日採血數', 'NS1 (+)', 'NS1 (-)', '備註');
        $expands = $this->Expand->find('all', array(
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
        ));
        foreach ($expands AS $expand) {
            $result[] = array($expand['Area']['name'], ($expand['Expand']['count_p'] + $expand['Expand']['count_n']), $expand['Expand']['count_p'], $expand['Expand']['count_n'], $expand['Expand']['note']);
        }
        return $result;
    }

    public function csvFever($theDate) {
        $result = array();
        $result[] = array('區別', '個案戶家人數', '個案戶家人發燒人數', '個案戶家人採血數', 'NS1 (+)', 'NS1 (-)', '備註');
        $fevers = $this->Fever->find('all', array(
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
        ));
        foreach ($fevers AS $fever) {
            $result[] = array($fever['Area']['name'], $fever['Fever']['count_people'], $fever['Fever']['count_fever'], $fever['Fever']['count_draw'], $fever['Fever']['count_p'], $fever['Fever']['count_n'], $fever['Fever']['note']);
        }
        return $result;
    }

    public function csvTrack($theDate) {
        $result = array();
        $result[] = array('區別', '社區應追蹤人數', '社區已追蹤人數', '完成率', '社區發燒人數', '社區發燒採血人數', '發燒率', '備註');
        $tracks = $this->Track->find('all', array(
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
        ));
        foreach ($tracks AS $track) {
            $result[] = array($track['Area']['name'], $track['Track']['track_count'], $track['Track']['track_done'],
                ($track['Track']['track_count'] > 0) ? (round($track['Track']['track_done'] / $track['Track']['track_count'], 3) * 100) . '%' : '',
                $track['Track']['fever_count'], $track['Track']['fever_draw'],
                ($track['Track']['track_count'] > 0) ? (round($track['Track']['fever_count'] / $track['Track']['track_count'], 3) * 100) . '%' : '',
                $track['Track']['note']);
        }
        return $result;
    }

    public function csvCenterSource($theDate) {
        $result = array();
        $result[] = array('區別 ', '里別 ', '調查戶數 ', '戶內積水容器 ', '戶內陽性容器 ', '戶內陽性率 ', '戶外積水容器 ', '戶外陽性容器 ', '戶外陽性率 ', '已處理陽性數 ', '舉發單數 ', '動員人數 ', '備註');
        $centerSources = $this->CenterSource->find('all', array(
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
        ));
        foreach ($centerSources AS $centerSource) {
            $result[] = array($centerSource['Area']['Parent']['name'],
                $centerSource['Area']['name'],
                $centerSource['CenterSource']['investigate'],
                $centerSource['CenterSource']['i_water'],
                $centerSource['CenterSource']['i_positive'],
                ($centerSource['CenterSource']['i_water'] > 0) ? (round($centerSource['CenterSource']['i_positive'] / $centerSource['CenterSource']['i_water'], 3) * 100) . '%' : '',
                $centerSource['CenterSource']['o_water'],
                $centerSource['CenterSource']['o_positive'],
                ($centerSource['CenterSource']['o_water'] > 0) ? (round($centerSource['CenterSource']['o_positive'] / $centerSource['CenterSource']['o_water'], 3) * 100) . '%' : '',
                $centerSource['CenterSource']['positive_done'],
                $centerSource['CenterSource']['fine'],
                $centerSource['CenterSource']['people'],
                $centerSource['CenterSource']['note'],);
        }
        return $result;
    }

    public function csvAreaSource($theDate) {
        $result = array();
        $result[] = array('區別 ', '里別 ', '調查戶數 ', '戶內積水容器 ', '戶內陽性容器 ', '戶內陽性率 ', '戶外積水容器 ', '戶外陽性容器 ', '戶外陽性率 ', '已處理陽性數 ', '動員人數 ', '備註');
        $areaSources = $this->AreaSource->find('all', array(
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
        ));
        foreach ($areaSources AS $areaSource) {
            $result[] = array($areaSource['Area']['Parent']['name'],
                $areaSource['Area']['name'],
                $areaSource['AreaSource']['investigate'],
                $areaSource['AreaSource']['i_water'],
                $areaSource['AreaSource']['i_positive'],
                ($areaSource['AreaSource']['i_water'] > 0) ? (round($areaSource['AreaSource']['i_positive'] / $areaSource['AreaSource']['i_water'], 3) * 100) . '%' : '',
                $areaSource['AreaSource']['o_water'],
                $areaSource['AreaSource']['o_positive'],
                ($areaSource['AreaSource']['o_water'] > 0) ? (round($areaSource['AreaSource']['o_positive'] / $areaSource['AreaSource']['o_water'], 3) * 100) . '%' : '',
                $areaSource['AreaSource']['positive_done'],
                $areaSource['AreaSource']['people'],
                $areaSource['AreaSource']['note'],
            );
        }
        return $result;
    }

    public function csvVolunteerSource($theDate) {
        $result = array();
        $result[] = array('區別 ', '里別 ', '調查戶數 ', '戶內積水容器 ', '戶內陽性容器 ', '戶內陽性率 ', '戶外積水容器 ', '戶外陽性容器 ', '戶外陽性率 ', '已處理陽性數 ', '志工人數 ', '備註');
        $volunteerSources = $this->VolunteerSource->find('all', array(
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
        ));
        foreach ($volunteerSources AS $volunteerSource) {
            $result[] = array($volunteerSource['Area']['Parent']['name'],
                $volunteerSource['Area']['name'],
                $volunteerSource['VolunteerSource']['investigate'],
                $volunteerSource['VolunteerSource']['i_water'],
                $volunteerSource['VolunteerSource']['i_positive'],
                ($volunteerSource['VolunteerSource']['i_water'] > 0) ? (round($volunteerSource['VolunteerSource']['i_positive'] / $volunteerSource['VolunteerSource']['i_water'], 3) * 100) . '%' : '',
                $volunteerSource['VolunteerSource']['o_water'],
                $volunteerSource['VolunteerSource']['o_positive'],
                ($volunteerSource['VolunteerSource']['o_water'] > 0) ? (round($volunteerSource['VolunteerSource']['o_positive'] / $volunteerSource['VolunteerSource']['o_water'], 3) * 100) . '%' : '',
                $volunteerSource['VolunteerSource']['positive_done'],
                $volunteerSource['VolunteerSource']['people'],
                $volunteerSource['VolunteerSource']['note'],
            );
        }
        return $result;
    }

    public function csvEducation($theDate) {
        $result = array();
        $result[] = array('單位', '宣導人次');
        $educations = $this->Education->find('all', array(
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
        ));
        foreach ($educations AS $education) {
            $result[] = array($education['Area']['name'] . $education['Education']['unit'], $education['Education']['education']);
        }
        return $result;
    }

    public function csvChemical($theDate) {
        $result = array();
        $result[] = array('區別 ', '里別 ', '戶外場次 ', '戶內應完成戶數 ', '已完成戶數 ', '完噴率 ', '拒噴戶開單數 ', '人力支援數 ', '戶內積水容器 ', '戶內陽性容器 ', '戶內陽性率 ', '戶外積水容器 ', '戶外陽性容器 ', '戶外陽性率 ', '備註');
        $chemicals = $this->Chemical->find('all', array(
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
        ));
        foreach ($chemicals AS $chemical) {
            $result[] = array($chemical['Area']['Parent']['name'],
                $chemical['Area']['name'],
                $chemical['Chemical']['trips'],
                $chemical['Chemical']['door_count'],
                $chemical['Chemical']['door_done'],
                ($chemical['Chemical']['door_count'] > 0) ? (round($chemical['Chemical']['door_done'] / $chemical['Chemical']['door_count'], 3) * 100) . '%' : '',
                $chemical['Chemical']['fine'],
                $chemical['Chemical']['people'],
                $chemical['Chemical']['i_water'],
                $chemical['Chemical']['i_positive'],
                ($chemical['Chemical']['i_water'] > 0) ? (round($chemical['Chemical']['i_positive'] / $chemical['Chemical']['i_water'], 3) * 100) . '%' : '',
                $chemical['Chemical']['o_water'],
                $chemical['Chemical']['o_positive'],
                ($chemical['Chemical']['o_water'] > 0) ? (round($chemical['Chemical']['o_positive'] / $chemical['Chemical']['o_water'], 3) * 100) . '%' : '',
                $chemical['Chemical']['note'],);
        }
        return $result;
    }

    public function csvFeverMonitor($theDate) {
        $result = array();
        $result[] = array('區別 ', '應追蹤人數 ', '已追蹤人數 ', '未追蹤人數 ', '追蹤率 ', '備註');
        $feverMonitors = $this->FeverMonitor->find('all', array(
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
        ));
        foreach ($feverMonitors AS $feverMonitor) {
            $result[] = array($feverMonitor['Area']['name'],
                $feverMonitor['FeverMonitor']['people_count'],
                $feverMonitor['FeverMonitor']['people_track'],
                ($feverMonitor['FeverMonitor']['people_count'] - $feverMonitor['FeverMonitor']['people_track']),
                ($feverMonitor['FeverMonitor']['people_count'] > 0) ? (round($feverMonitor['FeverMonitor']['people_track'] / $feverMonitor['FeverMonitor']['people_count'], 3) * 100) . '%' : '',
                $feverMonitor['FeverMonitor']['note'],);
        }
        return $result;
    }

    public function csvClinicReport($theDate) {
        $result = array();
        $result[] = array('區域 ', '通報件數 ', 'NS1 (+) ', 'NS1 (-) ', '備註');
        $clinicReports = $this->ClinicReport->find('all', array(
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
        ));
        foreach ($clinicReports AS $clinicReport) {
            $result[] = array($clinicReport['Area']['name'],
                ($clinicReport['ClinicReport']['count_p'] + $clinicReport['ClinicReport']['count_n']),
                $clinicReport['ClinicReport']['count_p'],
                $clinicReport['ClinicReport']['count_n'],
                $clinicReport['ClinicReport']['note'],
            );
        }
        return $result;
    }

}
