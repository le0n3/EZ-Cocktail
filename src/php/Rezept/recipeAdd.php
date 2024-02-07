<?php
include_once("../DBConnector.php");
include_once("recipe.php");
var_dump($_POST);
$recipeName  = $_POST['Rezept'];
$recipeBeschribung = $_POST['Beschreibung'];
$recipeZubereitung = $_POST['Zubereitung'];
$recipeImage = $_POST['URL'];
$recipe = new Recipe("", $recipeName, $recipeBeschribung, $recipeZubereitung, $recipeImage);

$ingredeans = $_POST['zutaten'];
$ingredeansarray = array();

foreach ($ingredeans as $key => $quantety){
    $ingredeansarray[] = new Ingredient($key, "", "", $quantety['menge'], "", "","");
}

DBConnection::createRecipe($recipe, $ingredeansarray);