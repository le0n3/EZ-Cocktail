<?php
include_once("../php/DBConnector.php");
if(!array_key_exists('id', $_POST)){
    $zutat = $_POST['Zutat'];
    $menge = $_POST['Menge'];
    $ingredientId = $_POST['MeineZutatId'];

    //DBConnection::createIngredient(new Ingredient("", $zutat, $beschreibung,$menge, $typ, $einheit), $einheitKurzel);
}else{

    $id = $_POST['id'];
    $zutat = $_POST['Zutat'];
    $menge = $_POST['Menge'];
    $ingredientId = $_POST['MeineZutatId'];

    //DBConnection::updateIngredient(new Ingredient($id, $zutat, $beschreibung,$menge, $typ, $einheit));
}

header("Location: ../html/index.php");
die();