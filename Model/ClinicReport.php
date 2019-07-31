<?php

App::uses('AppModel', 'Model');

class ClinicReport extends AppModel {

    var $name = 'ClinicReport';
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
