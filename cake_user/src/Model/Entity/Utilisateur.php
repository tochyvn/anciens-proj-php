<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Utilisateur extends Entity
{

    // Rend les champs assignables en masse sauf pour le champ clé primaire "id".
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    // ...

}

