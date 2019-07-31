<?php

class Area extends AppModel {

    public $name = 'Area';
    public $actsAs = array('Tree');
    
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
    );

}
