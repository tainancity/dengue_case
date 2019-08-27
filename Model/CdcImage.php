<?php

App::uses('AppModel', 'Model');

class CdcImage extends AppModel {

    var $name = 'CdcImage';
    var $belongsTo = array(
        'CdcPoint' => array(
            'foreignKey' => 'cdc_point_id',
            'className' => 'CdcPoint',
        ),
        'MemberCreated' => array(
            'foreignKey' => 'created_by',
            'className' => 'Member',
        ),
    );

}
