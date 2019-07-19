<?php

App::uses('AppModel', 'Model');

class Issue extends AppModel {

    var $name = 'Issue';
    var $validate = array(
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
        'member_created' => array(
            'numberFormat' => array(
                'rule' => 'numeric',
                'message' => 'Wrong format',
                'allowEmpty' => true,
            ),
        ),
        'member_modified' => array(
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
        'MemberCreated' => array(
            'foreignKey' => 'member_created',
            'className' => 'Member',
        ),
        'MemberModified' => array(
            'foreignKey' => 'member_modified',
            'className' => 'Member',
        ),
    );
    var $hasMany = array(
        'Point' => array(
            'foreignKey' => 'Issue_id',
            'dependent' => false,
            'className' => 'Point',
        ),
    );
    
    function beforeSave($options = array()) {
        if($this->exists()) {
            $this->data['Issue']['member_modified'] = Configure::read('loginMember.id');
        } else {
            $this->data['Issue']['member_created'] = Configure::read('loginMember.id');
        }
        parent::beforeSave($options);
    }

}
