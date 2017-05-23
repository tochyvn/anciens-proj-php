<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class TrajetsTable extends Table {
    
    public function initialize(array $config) {
        $this->belongsTo('Users');
    } 
    
    public function validationDefault(Validator $validator) {
        $validator
            ->notEmpty('depart', 'Une station de depart est requise')
            ->requirePresence('depart', 'Une station de depart est requise')
            ->notEmpty('destination', 'Une station de destination est requise')
            ->requirePresence('destination', 'Une station de destination est requise');

        return $validator;
    }
    
}



