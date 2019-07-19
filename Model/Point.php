<?php

App::uses('AppModel', 'Model');

class Point extends AppModel {

    var $name = 'Point';
    var $validate = array(
        'point_type' => array(
            'numberFormat' => array(
                'rule' => 'numeric',
                'message' => 'Wrong format',
                'allowEmpty' => true,
            ),
        ),
        'longitude' => array(
            'numberFormat' => array(
                'rule' => 'numeric',
                'message' => 'Wrong format',
                'allowEmpty' => true,
            ),
        ),
        'latitude' => array(
            'numberFormat' => array(
                'rule' => 'numeric',
                'message' => 'Wrong format',
                'allowEmpty' => true,
            ),
        ),
    );
    var $actsAs = array(
    );
    var $belongsTo = array(
        'Issue' => array(
            'foreignKey' => 'Issue_id',
            'className' => 'Issue',
        ),
    );

    function afterSave($created, $options = array()) {
        
    }

}
