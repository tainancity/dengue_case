<?php

class AppModel extends Model {

    public $actsAs = array('Containable');
    public $recursive = -1;
    public $memberControl = false;

    public function checkUnique($data) {
        foreach ($data AS $key => $value) {
            if (empty($value)) {
                return false;
            }
            if ($this->id) {
                return !$this->hasAny(array(
                            'id !=' => $this->id, $key => $value,
                ));
            } else {
                return !$this->hasAny(array($key => $value));
            }
        }
    }
    
    public function beforeFind($query) {
        $sw = Configure::read('skipMemberControl');
        $loginMember = Configure::read('loginMember');
        if(!$sw && $loginMember['Group']['id'] != 1 && $this->memberControl) {
            $query['conditions'][$this->name . '.created_by'] = $loginMember['id'];
        }
        return $query;
    }

}
