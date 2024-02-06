<?php
include_once("../php/DBConnector.php");

// Überprüfung, ob die erforderlichen POST-Parameter vorhanden sind
if(empty($_POST['Zutat']) || empty($_POST['EinheitKürzel']) || empty($_POST['Einheit']) || empty($_POST['Typ']) || empty($_POST['Beschreibung'])) {
    echo "Alle Felder müssen ausgefüllt werden.";
    exit();
}

$ingredientName = $_POST['Zutat'];
$unitShort = $_POST['EinheitKürzel'];
$unit = $_POST['Einheit'];
$type = $_POST['Typ'];
$description = $_POST['Beschreibung'];

// Prüft, ob die ID gesetzt wurde und ob sie nicht leer ist
if(isset($_POST['id']) && !empty($_POST['id'])){
    $id = $_POST['id'];
    DBConnection::updateIngredient(new Ingredient($id, $ingredientName, $description, 0, $type, $unit, $unitShort));
} else {
    DBConnection::createIngredient(new Ingredient("", $ingredientName, $description, 0, $type, $unit, $unitShort));
}

header("Location: ../html/index.php");
die();