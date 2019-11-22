<?php

App::uses('AppModel', 'Model');

class CdcIssue extends AppModel {

    var $name = 'CdcIssue';
    var $belongsTo = array(
        'Area' => array(
            'foreignKey' => 'area_id',
            'className' => 'Area',
        ),
        'MemberCreated' => array(
            'foreignKey' => 'created_by',
            'className' => 'Member',
        ),
        'MemberModified' => array(
            'foreignKey' => 'modified_by',
            'className' => 'Member',
        ),
    );
    var $hasMany = array(
        'CdcImage' => array(
            'foreignKey' => 'cdc_issue_id',
            'dependent' => false,
            'className' => 'CdcImage',
        ),
    );
    public $validate = array(
        'date_found' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '這個欄位必填',
            ),
        ),
        'issue_date' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '這個欄位必填',
            ),
        ),
    );

}
