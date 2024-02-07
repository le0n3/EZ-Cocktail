<?php
include_once("../php/DBConnector.php");
include_once("../php/Rezept/rezept.php");

$recipes = DBConnection::getRecipesByIngredients();
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
    <link href="../css/topBar.css" rel="stylesheet">
    <link href="../css/card.css" rel="stylesheet">
    <link href="../css/ezCockTail.css" rel="stylesheet">
    <!--custom JS -->
    <script src="../js/myRecipes.js"></script>
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
            <span class="ms-4">Alle Rezepte</span>
        </a>
    </div>
</nav>
<div class="main">
    <div class="d-flex flex-column flex-shrink-0 bg-light vh-100">
        <ul class="nav nav-pills nav-flush flex-column mb-auto text-center sticky-top top-0">
            <li class="nav-item">
                <a href="index.php" class="nav-link py-3 border-bottom" aria-current="page" title="Alle Zutaten" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Alle Zutaten">
                    <span class="icon icon-grocery"></span>
                </a>
            </li>
            <li class="nav-item">
                <a href="myIngredients.php" class="nav-link py-3 border-bottom" aria-current="page" title="Meine Zutaten" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Meine Zutaten">
                    <span class="icon icon-grocery"></span>
                </a>
            </li>
            <li>
                <a href="allRecipes.php" class="nav-link py-3 border-bottom" aria-current="page" title="Alle Rezepte" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Alle Rezepte">
                    <span class="icon icon-format_list_bulleted"></span>
                </a>
            </li>
            <li>
                <a href="myRecipes.php" class="nav-link py-3 border-bottom active" aria-current="page" title="Mögliche Rezepte" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Mögliche Rezepte">
                    <span class="icon icon-checklist"></span>
                </a>
            </li>
        </ul>
    </div>
    <div class="w-100">
        <!--for future implementation-->
        <div class="row d-none">
            <!--          <div class="filter-container m-auto shadow rounded bg-light">-->
            <!--            <div class="">-->
            <!--              <div class="row"><h1>Filter</h1></div>-->
            <!--              <div class="row">-->
            <!--                <div class="col">-->
            <!--                  <div class="mb-3">-->
            <!--                    <label for="recipeName" class="form-label">Rezeptname</label>-->
            <!--                    <input type="text" class="form-control" id="recipeName">-->
            <!--                  </div>-->
            <!--                </div>-->
            <!--                <div class="col">-->
            <!--                  <div class="mb-3">-->
            <!--                    <label for="difficulty" class="form-label">Schwierigkeit</label>-->
            <!--                    <input type="text" class="form-control" id="difficulty">-->
            <!--                  </div>-->
            <!--                </div>-->
            <!--                -->
            <!--              </div>-->
            <!--            </div>-->
        </div>
        <div class="row">
            <div class="cards-container m-auto shadow rounded bg-light">
                <?php
                foreach($recipes as $recipe)
                {
                    echo $recipe->generateRecepeCard();
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="recipeDetail" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form action="../php/Rezept/recipeMixed.php">
                <div class="modal-content">
                    <div class="modal-content" id="detailInfo"></div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
                        <button type="submit" class="btn btn-primary">Zubereiten</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</body>
</html>