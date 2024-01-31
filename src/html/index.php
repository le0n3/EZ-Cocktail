<?php
include_once("../php/DBConnector.php");

$filterName = array_key_exists("Name",$_REQUEST) ? $_REQUEST['Name'] : "";
$filterMenge = array_key_exists("Menge",$_REQUEST) ? $_REQUEST['Menge'] : "";
$filterEinheit = array_key_exists("Einheit", $_REQUEST) ? $_REQUEST['Einheit'] : "";
$filterTyp = array_key_exists("Typ", $_REQUEST) ? $_REQUEST['Typ']: "";
$filterBeschreibung = array_key_exists("Beschreibung", $_REQUEST) ? $_REQUEST['Beschreibung']: "";

$Ingredients = DBConnection::readFiltertngredient($filterName, $filterMenge, $filterEinheit, $filterTyp, $filterBeschreibung);

?>

<!doctype html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EZ CockTail</title>
    <!-- Bootstrap -->
    <link href="../Bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="../Bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Custom Icons -->
    <link href="../icons/icons.css" rel="stylesheet">

    <!-- custom CSS -->
    <link href="../css/table.css" rel="stylesheet">
    <link href="../css/index.css" rel="stylesheet">
    <link href="../css/topBar.css" rel="stylesheet">
    <link href="../css/ezCockTail.css" rel="stylesheet">
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="d-block justify-left ms-2">
            <a class="navbar-brand">
                <span class="icon icon-local_bar"></span>
                <span>EZ-Cocktail</span>
            </a>
            <a>•</a>
            <a class="navbar-brand">
                <span class="ms-4">Meine Zutaten</span>
            </a>
        </div>
      </nav>
    <div class="main">
        <div class="d-flex flex-column flex-shrink-0 bg-light vh-100">
            <ul class="nav nav-pills nav-flush flex-column mb-auto text-center sticky-top top-0">
              <li class="nav-item">
                <a href="index.php" class="nav-link active py-3 border-bottom" aria-current="page" title="Meine Zutaten" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Meine Zutaten">
                    <span class="icon icon-grocery"></span>
                </a>
              </li>
              <li>
                <a href="allRecipes.php" class="nav-link py-3 border-bottom" title="Alle Rezepte" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Alle Rezepte">
                    <span class="icon icon-format_list_bulleted"></span>
                </a>
              </li>
              <li>
                <a href="#" class="nav-link py-3 border-bottom" title="Mögliche Rezepte" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Mögliche Rezepte">
                    <span class="icon icon-checklist"></span>
                </a>
              </li>
            </ul>
          </div>
          <div class="table-container w-100 m-5 shadow rounded">
            <table class="table bg-body table-striped">
                <thead class="bg-light sticky-top top-0">
                    <tr>
                        <th scope="col"><span class="icon icon-add_circle" title="Eintrag hinzufügen"></span></th>
                        <th scope="col" class="table-name"><span>Name</span><span class="icon icon-expand_more text-primary"></span></th>
                        <th scope="col" class="table-amount"><span>Menge</span><span class="icon icon-unfold_more"></span></th>
                        <th scope="col" class="table-unit"><span>Einheit</span><span class="icon icon-unfold_more"></span></th>
                        <th scope="col" class="table-type"><span>Typ</span><span class="icon icon-unfold_more"></span></th>
                        <th scope="col" class="table-final-col"><span>Beschreibung</span><span class="icon icon-unfold_more"></span></th>
                    </tr>
                    <tr>
                        <th scope="col" class="table-icon">
                           <a href="index.php"> <span class="icon icon-close top-1" title="Filter entfernen"></span></a>
                        </th>
                        <th scope="col" class="table-name"><input type="text" value="<?php echo $filterName; ?>"></th>
                        <th scope="col" class="table-amount"><input type="text" value="<?php echo $filterMenge; ?>"></th>
                        <th scope="col" class="table-unit"><input type="text" value="<?php echo $filterEinheit; ?>"></th>
                        <th scope="col" class="table-type"><input type="text" value="<?php echo $filterTyp; ?>"></th>
                        <th scope="col" class="table-final-col"><input type="text" value="<?php echo $filterBeschreibung; ?>"></th>
                    </tr>
                </thead>
                <tbody>

                <?php

                foreach($Ingredients as $ingredient)
                {
                    echo $ingredient->generateIngredientLine();
                }


        ?>

                </tbody>
              </table>
        </div>
    </div>
   </body>
</html>