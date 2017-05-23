<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of regex
 *
 * @author Guillaume
 */
class regex {
    
    const TAB = "\t";
    const CR = "\r";
    const LF = "\n";
    const CRLF = "\r\n";
    
    const STRING_FILTRE_EMAIL = '^[a-zA-Z0-9]+([_.-][a-zA-Z0-9]+)*@[a-zA-Z0-9]+([.-][a-zA-Z0-9]+)*\.[a-zA-Z]{2,4}$';
    public $STRING_TROUVE_EMAIL = '';
    
    public $recherche_tous = array
    (
            '/:point virgule:/',
            '/:saut ligne:/',
            '/:saut paragraphe:/',
            '/:guillemet:/'
    );
    public $remplacement_tous = array
    (
            ';',
            
            '"'
    );

    public $recherche_type = array
    (
            '/ +/',
            '/(^ +| +$)/',
            '/(^|[^A-Z])([1-9])( |\r\n|\r|\n)?pi.ces?([^A-Z]|$)/i',
            '/T([0-9]) et plus/i',
            '/ et plus/'
    );
    
    public $remplacement_type = array
    (
            ' ',
            '',
            '$2',
            'T$1',
            ''
    );

    public $recherche_titre_descriptif = array
    (
            '/(dans|ds)[^a-z]+(une?[^a-z]+)?((beau|belle)[^a-z]+)?(mais\.|maison|villa|pavillon|demeure|bastide)/i',
            '/(rdc|rez de chauss[�e])[^a-z]+(de|d\'une?)[^a-z]+((beau|belle)[^a-z]+)?(mais\.|maison|villa|pavillon|demeure|bastide)/i',
            '/[�|e]tage[^a-z]+(de|d\'une?)[^a-z]+((beau|belle)[^a-z]+)?(mais\.|maison|villa|pavillon|demeure|bastide)/i'
    );
    
    public $remplacement_titre_descriptif = array
    (
            ' ',
            ' ',
            ' '
    );

    public $type_niveau1 = array
    (
            'mais\.'=>'maison',
            'maisons?'=>'maison',
            'villas?'=>'villa',
            'pavillons?'=>'pavillon',
            'demeures?'=>'demeure',
            'bastides?'=>'bastide',
            'mas'=>'mas'
    );
    
    public $type_niveau2 = array
    (
            'loft'=>'loft',
            'duplex'=>'duplex',
            'triplex'=>'triplex',
            '(T|F)1(bis)?'=>'T1',
            '(T|F)2(bis)?'=>'T2',
            '(T|F)3(bis)?'=>'T3',
            '(T|F)4(bis)?'=>'T4',
            '(T|F)5(bis)?'=>'T5',
            '(T|F)6(bis)?'=>'T6',
            '(T|F)7(bis)?'=>'T7',
            '(T|F)8(bis)?'=>'T8',
            '(T|F)9(bis)?'=>'T9',
            'Type 1(bis)?'=>'T1',
            'Type 2(bis)?'=>'T2',
            'Type 3(bis)?'=>'T3',
            'Type 4(bis)?'=>'T4',
            'Type 5(bis)?'=>'T5',
            'Type 6(bis)?'=>'T6',
            'Type 7(bis)?'=>'T7',
            'Type 8(bis)?'=>'T8',
            'Type 9(bis)?'=>'T9',
            'studios?'=>'studio',
            'studettes?'=>'studette',
            'bateaux?'=>'bateau',
            'péniches?'=>'péniche'
    );
    public $type_niveau3 = array
    (
            '(1|une) ?(pi.ce|pce)'=>'T1',
            '(2|deux) ?(pi.ce|pce)s?'=>'T2',
            '(3|trois) ?(pi.ce|pce)s?'=>'T3',
            '(4|quatre) ?(pi.ce|pce)s?'=>'T4',
            '(5|cinq) ?(pi.ce|pce)s?'=>'T5',
            '(6|six) ?(pi.ce|pce)s?'=>'T6',
            '(7|sept) ?(pi.ce|pce)s?'=>'T7',
            '(8|huit) ?(pi.ce|pce)s?'=>'T8',
            '(9|huit) ?(pi.ce|pce)s?'=>'T9',
            '(1|une) ?(chambre|ch|chbre)'=>'T2',
            '(2|deux) ?(chambre|ch|chbre)s?'=>'T3',
            '(3|trois) ?(chambre|ch|chbre)s?'=>'T4',
            '(4|quatre) ?(chambre|ch|chbre)s?'=>'T5',
            '(5|cinq) ?(chambre|ch|chbre)s?'=>'T6',
            '(6|six) ?(chambre|ch|chbre)s?'=>'T7',
            '(7|sept) ?(chambre|ch|chbre)s?'=>'T8',
            '(8|huit) ?(chambre|ch|chbre)s?'=>'T9'
    );
    
    public $type_niveau4 = array
    (
            'loca(l|aux)'=>'local',
            'bureaux?'=>'bureau',
            'ateliers?'=>'atelier',
            'hangars?'=>'hangar',
            'entrep.ts?'=>'entrepot',
            '(garage|gge)s?'=>'garage',
            '(park(ing)|pkg)?'=>'parking',
            'caves?'=>'cave',
            'box'=>'box',
            'colocation'=>'colocation',
            'chambre de bonne'=>'ch. de bonne',
            'fermes?'=>'ferme',
            'fermettes?'=>'fermette'
    );
    
    public $type_non_niveau1 = array
    (
            'appart',
            'studio',
            'studette',
            'f1',
            'f2',
            't1',
            't2'
    );
			
    public $type_maison_recherche = array
    (
            '(T|F)1(bis)?'=>'T1',
            '(T|F)2(bis)?'=>'T2',
            'Type 1(bis)?'=>'T1',
            'Type 2(bis)?'=>'T2',
            'studios?'=>'studio',
            'studettes?'=>'studette'
    );

    public $recherche_ville = array
    (
            '/-/',
            '/(^|[^A-Z])ST([^A-Z]|$)/',
            '/(^|[^A-Z])STE([^A-Z]|$)/',
            '/(^|[^A-Z])S?\/([^A-Z]|$)/',
            '/(^|[^A-Z])D /',
            '/(^|[^A-Z])L /',
            '/\' /',
            '/ CEDEX.*/',
            '/(^|[^A-Z])(A )?[0-9]+ ?KM (DE )?|AUTOUR DE |SECTEUR (DE )?|PROCHE (DE )?/',
            '/(^|[^A-Z])(SUD|NORD|EST|OUEST) DE /',
            '/(^|[^A-Z])(SUD|NORD|EST|OUEST) /',
            '/ (SUD|NORD|EST|OUEST)([^A-Z]|$)/',
            '/ CENTRE$/',
            '/^CENTRE /',
            '/^REGION /',
            '/[^A-Z]+\((LE|LA|LES|L\')\)$/',
            '/ \([^\/0-9]+\)/',
            '/ +/',
            '/(^ +| +$)/'
    );
    
    public $remplacement_ville = array
    (
            ' ',
            '$1SAINT$2',
            '$1SAINTE$2',
            '$1SUR$2',
            '$1D\'',
            '$1L\'',
            '\'',
            '',
            '',
            '$1',
            '$1',
            '$2',
            '',
            '',
            '',
            '$1 ',
            '',
            ' ',
            ''
    );
    
    public function __construct() {
        $this->STRING_TROUVE_EMAIL = '('.substr(self::STRING_FILTRE_EMAIL,1,strlen(self::STRING_FILTRE_EMAIL)-2).')';
    }
    
}
