<?php

App::uses('AppModel', 'Model');

class DailyCase extends AppModel {

    var $name = 'DailyCase';
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


}
