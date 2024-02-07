<?php

include_once("../DBConnector.php");
header("Location: ../html/myRecipes.php");

// Überprüfung, ob die erforderlichen POST-Parameter vorhanden sind
if (empty($_POST['id'])) {
    echo "Alle Felder müssen ausgefüllt werden.";
    exit();
}

//Entfernt die benötigten Zutaten und deren menge aus dem rezept
DBConnection::recipeDone($_POST['id']);

die();