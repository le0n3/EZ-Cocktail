<?php
include_once("../php/DBConnector.php");
if(!array_key_exists('id', $_POST)){
    $zutat = $_POST['Zutat'];
    $menge = $_POST['Menge'];
    $einheitKurzel = $_POST['EinheitKürzel'];
    $einheit = $_POST['Einheit'];
    $typ = $_POST['Typ'];
    $beschreibung = $_POST['Beschreibung'];

    DBConnection::createIngredient(new Ingredient("", $zutat, $beschreibung,$menge, $typ, $einheit), $einheitKurzel);
}else{

    $id = $_POST['id'];
    $zutat = $_POST['Zutat'];
    $menge = $_POST['Menge'];
    $einheitKurzel = $_POST['EinheitKürzel'];
    $einheit = $_POST['Einheit'];
    $typ = $_POST['Typ'];
    $beschreibung = $_POST['Beschreibung'];

    DBConnection::updateIngredient(new Ingredient($id, $zutat, $beschreibung,$menge, $typ, $einheit));
}
