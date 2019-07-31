<?php

App::uses('AppModel', 'Model');

class BureauSource extends AppModel {

    var $name = 'BureauSource';
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
