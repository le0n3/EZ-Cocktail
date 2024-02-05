<?php
include_once("../php/DBConnector.php");
if(!array_key_exists('MeineZutatId', $_POST)){
    $menge = $_POST['Menge'];
    $ingredientId = $_POST['MeineZutatId'];//Wie komme ich hir an die ZutatID

    DBConnection::createQuantetyOffIngerdeans($ingredientId, $menge);
}else{

    $menge = $_POST['Menge'];
    $ingredientId = $_POST['MeineZutatId'];

    DBConnection::uptareQuantetyOffIngerdeans($ingredientId, $menge);
}

header("Location: ../html/myIngredients.php");
die();