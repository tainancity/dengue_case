<?php

App::uses('AppModel', 'Model');

class Fever extends AppModel {

    var $name = 'Fever';
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
