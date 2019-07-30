<?php

App::uses('AppModel', 'Model');

class Track extends AppModel {

    var $name = 'Track';
    var $belongsTo = array(
        'Area' => array(
            'foreignKey' => 'area_id',
            'className' => 'Area',
        ),
        'Created' => array(
            'foreignKey' => 'created_by',
            'className' => 'Member',
        ),
        'Modified' => array(
            'foreignKey' => 'modified_by',
            'className' => 'Member',
        ),
    );

}
