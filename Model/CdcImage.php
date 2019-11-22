<?php

App::uses('AppModel', 'Model');

class CdcImage extends AppModel {

    var $name = 'CdcImage';
    var $belongsTo = array(
        'CdcIssue' => array(
            'foreignKey' => 'cdc_issue_id',
            'className' => 'CdcIssue',
        ),
        'MemberCreated' => array(
            'foreignKey' => 'created_by',
            'className' => 'Member',
        ),
    );

}
