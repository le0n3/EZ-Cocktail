<?php
include_once("../php/DBConnector.php");
if(!array_key_exists('Id', $_POST)){
    $menge = $_POST['Menge'];
    $ingredientId = $_POST['MeineZutatId'];

    DBConnection::createQuantetyOffIngerdeans($ingredientId, $menge);
}else{

    $menge = $_POST['Menge'];
    $ingredientId = $_POST['Id'];

    DBConnection::uptareQuantetyOffIngerdeans($ingredientId, $menge);
}

header("Location: ../html/myIngredients.php");
die();