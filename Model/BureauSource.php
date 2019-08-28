<?php

App::uses('AppModel', 'Model');

class BureauSource extends AppModel {

    var $name = 'BureauSource';
    public $memberControl = true;
    var $belongsTo = array(
        'MemberCreated' => array(
            'foreignKey' => 'created_by',
            'className' => 'Member',
        ),
        'MemberModified' => array(
            'foreignKey' => 'modified_by',
            'className' => 'Member',
        ),
    );

    public function csvBureauSource($theDate) {
        $result = array();
        $result[] = array('局處 ', '檢查地點數 ', '戶內積水容器 ', '戶內陽性容器 ', '戶內陽性率 ', '戶外積水容器 ', '戶外陽性容器 ', '戶外陽性率 ', '已處理陽性數 ', '宣導人次 ', '動員人數 ', '檢查地點（名稱） ', '備註');
        $bureauSources = $this->find('all', array(
            'conditions' => array(
                'BureauSource.the_date' => $theDate,
            ),
        ));
        foreach ($bureauSources AS $bureauSource) {
            $result[] = array($bureauSource['BureauSource']['unit'],
                $bureauSource['BureauSource']['investigate'],
                $bureauSource['BureauSource']['i_water'],
                $bureauSource['BureauSource']['i_positive'],
                ($bureauSource['BureauSource']['i_water'] > 0) ? (round($bureauSource['BureauSource']['i_positive'] / $bureauSource['BureauSource']['i_water'], 3) * 100) . '%' : '',
                $bureauSource['BureauSource']['o_water'],
                $bureauSource['BureauSource']['o_positive'],
                ($bureauSource['BureauSource']['o_water'] > 0) ? (round($bureauSource['BureauSource']['o_positive'] / $bureauSource['BureauSource']['o_water'], 3) * 100) . '%' : '',
                $bureauSource['BureauSource']['positive_done'],
                $bureauSource['BureauSource']['education'],
                $bureauSource['BureauSource']['people'],
                $bureauSource['BureauSource']['location'],
                $bureauSource['BureauSource']['note'],);
        }
        return $result;
    }

}
