<?php

App::uses('AppModel', 'Model');

class Track extends AppModel {

    var $name = 'Track';
    public $memberControl = true;
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

}
