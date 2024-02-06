<?php
include_once("../php/DBConnector.php");

// Überprüfung, ob die erforderlichen POST-Parameter vorhanden sind
if(empty($_POST['Menge']) || empty($_POST['MeineZutatId']) || (array_key_exists('Id', $_POST) && !empty($_POST['Id']))) {
    // Zeigt eine Fehlermeldung an und beendet das Skript, wenn die erforderlichen POST-Parameter nicht gefunden werden
    echo "Alle Felder müssen ausgefüllt werden.";
    exit();
}

// Die Werte aus dem Post-Array holen
$quantity = $_POST['Menge'];
$ingredientId = array_key_exists('Id', $_POST) ? $_POST['Id'] : $_POST['MeineZutatId'];

// Prüft, ob die ID gesetzt wurde und ob sie nicht leer ist
if(array_key_exists('Id', $_POST) && !empty($_POST['Id'])){
    DBConnection::updateQuantityOfIngredients($ingredientId, $quantity);
} else {
    DBConnection::createQuantityOfIngredients($ingredientId, $quantity);
}

header("Location: ../html/myIngredients.php");
die();