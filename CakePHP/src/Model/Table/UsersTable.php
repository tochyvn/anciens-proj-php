<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class UsersTable extends Table
{
    
    public function initialize(array $config) {
        $this->addBehavior('Timestamp');
    }

    public function validationDefault(Validator $validator)
    {
        return $validator
            ->notEmpty('username', "Un nom d'utilisateur est nécessaire")
            ->requirePresence('username', "Un nom d'utilisateur est requis")
            ->notEmpty('password', 'Un mot de passe est nécessaire')
            ->requirePresence('password', "Un mot de passe est requis")
            ->notEmpty('role', 'Un role est nécessaire')
            ->add('role', 'inList', [
                'rule' => ['inList', ['admin', 'author']],
                'message' => 'Merci de rentrer un role valide'
            ]);
    }

}

