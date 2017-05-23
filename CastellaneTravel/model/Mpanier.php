<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include 'model/Mproduit.php';


/**
 * DANS CETTE VERSION ON INTERROGE LA BD
 * @param type $id
 * @return int
 */
function ajoutProduitPanier($id) {
    
    /*
     * SI CE PRODUIT EST DEJA DANS LE PANIER
     */
    if (array_key_exists($id, $_SESSION['panier'])) {
        echo 'Ce produit est existant<br/>';
        $_SESSION['panier'][$id]['qte'] = $_SESSION['panier'][$id]['qte'] + 1;
    }
    else{
        echo 'Ce produit est inexistant<br/>';
        $produit = selectProduit($id);
        $_SESSION['panier'][$produit['idProduit']] = array(
                    'nomFR' => $produit['nomProduitFR'],
                    'nomENG' => $produit['nomProduitENG'],
                    'prix' => $produit['prixProduit'],
                    'descFR' => $produit['descriptProduitFR'],
                    'descENG' => $produit['descriptProduitENG'],
                    'idSoc' => $produit['idSociete'],
                    'qte' => 1
                );
    }
    
    return $_SESSION['panier'];
        
}
/**
 * DANS CETTE VERSION DE LA METHODE ON INTERROGE PLUS LA BASE DE DONNEES
 * @param type $array
 * @return int
 */
function ajoutProduitPanier1($array) {
    $id = test_input($array['idProduit']);
    /*
     * SI CE PRODUIT EST DEJA DANS LE PANIER
     */
    if (array_key_exists($id, $_SESSION['panier'])) {
        echo 'Ce produit est existant<br/>';
        $_SESSION['panier'][$id]['qte'] = $_SESSION['panier'][$id]['qte'] + 1;
    }
    else {
        echo 'Ce produit est inexistant<br/>';
        //$produit = selectProduit($id);
        $_SESSION['panier'][$id] = array(
                    'nomFR' => test_input($array['nomProduitFR']),
                    'nomENG' => test_input($array['nomProduitENG']),
                    'prix' => test_input($array['prixProduit']),
                    'descFR' => test_input($array['descriptProduitFR']),
                    'descENG' => test_input($array['descriptProduitENG']),
                    'idSoc' => test_input($array['idSociete']),
                    'qte' => 1,
                );
    }
    
    //return $_SESSION['panier'];
        
}

function suppProduitPanier($id) {
    
    if (array_key_exists($id, $_SESSION['panier'])) {
        if ($_SESSION['panier'][$id]['qte'] > 1) {
            $_SESSION['panier'][$id]['qte'] = $_SESSION['panier'][$id]['qte'] - 1;
        }
        else {
            unset($_SESSION['panier'][$id]);
        }
        return $_SESSION['panier'];
    }
    
}

function ajoutQteProduit($id) {
    $qte = qteProduit($id);
    $qte_final = $qte + 1;
    
    return $qte_final;
}

function voirProduitPanier() {
    $resultat = array();
    if (nombreProduit() == 0) {
        $resultat['msg'] = "Votre panier est vide";
        $resultat['img'] = "url de l'image";
    }
    else {
         $resultat = $_SESSION['panier'];     
    }
    
    return $resultat;
}

function validerPanier() {
    
}

function nombreProduit() {
    $nombre = count($_SESSION['panier']);
    
    return $nombre;
}

function qteProduit($id) {
    $qte = $_SESSION['panier'][$id]['qte'];
    
    return $qte;
}

function viderPanier() {
    unset($_SESSION['panier']);
    $_SESSION['panier'] = array();
}

function prixParProduit($id) {
    $prix = $_SESSION['panier'][$id]['prix'] * qteProduit($id);
    
    return $prix;
}

function prixTotalPanier() {
    $panier = $_SESSION['panier'];
    $total = 0;
    foreach ($panier as $id => $produit) {
        $total = $total + $produit[$id]['prix'] * $produit[$id]['qté'];
    }
}

function commander() {
    
}
