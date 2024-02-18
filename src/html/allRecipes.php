<?php
include_once("../php/DBConnector.php");
include_once("../php/Rezept/rezept.php");

$recipes = DBConnection::readAllRecipes();
$ingredients = DBConnection::readFiltertIngredient(true);
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
    <link href="../css/allRecipes.css" rel="stylesheet">
    <!--custom JS -->
    <script src="../js/allRecipes.js"></script>
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
                <a href="allRecipes.php" class="nav-link py-3 border-bottom active" aria-current="page" title="Alle Rezepte" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Alle Rezepte">
                    <span class="icon icon-format_list_bulleted"></span>
                </a>
            </li>
            <li>
                <a href="myRecipes.php" class="nav-link py-3 border-bottom" aria-current="page" title="Mögliche Rezepte" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Mögliche Rezepte">
                    <span class="icon icon-checklist"></span>
                </a>
            </li>
        </ul>
    </div>
    <div class="w-100">
        <div class="row">
            <div class="cards-container m-auto shadow rounded bg-light">
                <div class="card" id="add_entry_card" data-bs-toggle="modal" data-bs-target="#recipeAdd">
                    <img src="../Images/plus.png" class="card-img-top" alt="cooler-gandalf">
                    <div class="card-body">
                        <h5 class="card-title">Hinzufügen</h5>
                        <div class="description-container">
                            Neues Rezept erstellen
                        </div>
                    </div>
                </div>

                <div class="card openDetails" data-bs-toggle="modal" data-bs-target="#recipeDetail" data-id="1">
                    <img src="https://media3.giphy.com/media/TcdpZwYDPlWXC/giphy.gif" class="card-img-top" alt="cooler-gandalf">
                    <div class="card-body">
                        <h5 class="card-title">Jacky Cola</h5>
                        <div class="description-container">
                            erklrt sich ziemlich von allein
                        </div>
                    </div>
                </div><div class="card openDetails" data-bs-toggle="modal" data-bs-target="#recipeDetail" data-id="1">
                    <img src="https://media3.giphy.com/media/TcdpZwYDPlWXC/giphy.gif" class="card-img-top" alt="cooler-gandalf">
                    <div class="card-body">
                        <h5 class="card-title">Jacky Cola</h5>
                        <div class="description-container">
                            erklrt sich ziemlich von allein
                        </div>
                    </div>
                </div><div class="card openDetails" data-bs-toggle="modal" data-bs-target="#recipeDetail" data-id="1">
                    <img src="https://media3.giphy.com/media/TcdpZwYDPlWXC/giphy.gif" class="card-img-top" alt="cooler-gandalf">
                    <div class="card-body">
                        <h5 class="card-title">Jacky Cola</h5>
                        <div class="description-container">
                            erklrt sich ziemlich von allein
                        </div>
                    </div>
                </div><div class="card openDetails" data-bs-toggle="modal" data-bs-target="#recipeDetail" data-id="1">
                    <img src="https://media3.giphy.com/media/TcdpZwYDPlWXC/giphy.gif" class="card-img-top" alt="cooler-gandalf">
                    <div class="card-body">
                        <h5 class="card-title">Jacky Cola</h5>
                        <div class="description-container">
                            erklrt sich ziemlich von allein
                        </div>
                    </div>
                </div><div class="card openDetails" data-bs-toggle="modal" data-bs-target="#recipeDetail" data-id="1">
                    <img src="https://media3.giphy.com/media/TcdpZwYDPlWXC/giphy.gif" class="card-img-top" alt="cooler-gandalf">
                    <div class="card-body">
                        <h5 class="card-title">Jacky Cola</h5>
                        <div class="description-container">
                            erklrt sich ziemlich von allein
                        </div>
                    </div>
                </div><div class="card openDetails" data-bs-toggle="modal" data-bs-target="#recipeDetail" data-id="1">
                    <img src="https://media3.giphy.com/media/TcdpZwYDPlWXC/giphy.gif" class="card-img-top" alt="cooler-gandalf">
                    <div class="card-body">
                        <h5 class="card-title">Jacky Cola</h5>
                        <div class="description-container">
                            erklrt sich ziemlich von allein
                        </div>
                    </div>
                </div><div class="card openDetails" data-bs-toggle="modal" data-bs-target="#recipeDetail" data-id="1">
                    <img src="https://media3.giphy.com/media/TcdpZwYDPlWXC/giphy.gif" class="card-img-top" alt="cooler-gandalf">
                    <div class="card-body">
                        <h5 class="card-title">Jacky Cola</h5>
                        <div class="description-container">
                            erklrt sich ziemlich von allein
                        </div>
                    </div>
                </div><div class="card openDetails" data-bs-toggle="modal" data-bs-target="#recipeDetail" data-id="1">
                    <img src="https://media3.giphy.com/media/TcdpZwYDPlWXC/giphy.gif" class="card-img-top" alt="cooler-gandalf">
                    <div class="card-body">
                        <h5 class="card-title">Jacky Cola</h5>
                        <div class="description-container">
                            erklrt sich ziemlich von allein
                        </div>
                    </div>
                </div><div class="card openDetails" data-bs-toggle="modal" data-bs-target="#recipeDetail" data-id="1">
                    <img src="https://media3.giphy.com/media/TcdpZwYDPlWXC/giphy.gif" class="card-img-top" alt="cooler-gandalf">
                    <div class="card-body">
                        <h5 class="card-title">Jacky Cola</h5>
                        <div class="description-container">
                            erklrt sich ziemlich von allein
                        </div>
                    </div>
                </div><div class="card openDetails" data-bs-toggle="modal" data-bs-target="#recipeDetail" data-id="1">
                    <img src="https://media3.giphy.com/media/TcdpZwYDPlWXC/giphy.gif" class="card-img-top" alt="cooler-gandalf">
                    <div class="card-body">
                        <h5 class="card-title">Jacky Cola</h5>
                        <div class="description-container">
                            erklrt sich ziemlich von allein
                        </div>
                    </div>
                </div><div class="card openDetails" data-bs-toggle="modal" data-bs-target="#recipeDetail" data-id="1">
                    <img src="https://media3.giphy.com/media/TcdpZwYDPlWXC/giphy.gif" class="card-img-top" alt="cooler-gandalf">
                    <div class="card-body">
                        <h5 class="card-title">Jacky Cola</h5>
                        <div class="description-container">
                            erklrt sich ziemlich von allein
                        </div>
                    </div>
                </div><div class="card openDetails" data-bs-toggle="modal" data-bs-target="#recipeDetail" data-id="1">
                    <img src="https://media3.giphy.com/media/TcdpZwYDPlWXC/giphy.gif" class="card-img-top" alt="cooler-gandalf">
                    <div class="card-body">
                        <h5 class="card-title">Jacky Cola</h5>
                        <div class="description-container">
                            erklrt sich ziemlich von allein
                        </div>
                    </div>
                </div><div class="card openDetails" data-bs-toggle="modal" data-bs-target="#recipeDetail" data-id="1">
                    <img src="https://media3.giphy.com/media/TcdpZwYDPlWXC/giphy.gif" class="card-img-top" alt="cooler-gandalf">
                    <div class="card-body">
                        <h5 class="card-title">Jacky Cola</h5>
                        <div class="description-container">
                            erklrt sich ziemlich von allein
                        </div>
                    </div>
                </div><div class="card openDetails" data-bs-toggle="modal" data-bs-target="#recipeDetail" data-id="1">
                    <img src="https://media3.giphy.com/media/TcdpZwYDPlWXC/giphy.gif" class="card-img-top" alt="cooler-gandalf">
                    <div class="card-body">
                        <h5 class="card-title">Jacky Cola</h5>
                        <div class="description-container">
                            erklrt sich ziemlich von allein
                        </div>
                    </div>
                </div><div class="card openDetails" data-bs-toggle="modal" data-bs-target="#recipeDetail" data-id="1">
                    <img src="https://media3.giphy.com/media/TcdpZwYDPlWXC/giphy.gif" class="card-img-top" alt="cooler-gandalf">
                    <div class="card-body">
                        <h5 class="card-title">Jacky Cola</h5>
                        <div class="description-container">
                            erklrt sich ziemlich von allein
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="recipeDetail" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                    <input type="hidden" name="destination" value="allRecipes.php">
                    <div class="modal-content" id="detailInfo"></div>
            </div>
        </div>

        <div class="modal fade" id="recipeAdd" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="../php/recipeAdd.php" autocomplete="off" method="post">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTitle">Rezept hinzufügen</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="container">
                                <div class="row mb-2">
                                    <div class="col">
                                        <label for="Rezept" class="form-label">Rezept</label>
                                        <input required type="text" class="form-control" id="Rezept" name="Rezept">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">
                                        <label for="URL" class="form-label">URL</label>
                                        <input required type="text" class="form-control" id="URL" name="URL">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="Beschreibung" class="form-label">Beschreibung</label>
                                    <textarea required class="form-control" id="Beschreibung" name="Beschreibung" rows="3" style="margin-left: 13px;width: 95%;"></textarea>
                                </div>
                                <div class="row mb-2">
                                    <div class="container">
                                        <table class="table-primary" id="ingredientsTable">
                                            <thead>
                                            <tr>
                                                <th class="w-100" colspan="100%">
                                                    <label class="w-100">
                                                        <select class="form-select ingredientSelectElement">
                                                            <option selected disabled>Bitte wählen</option>
                                                            <?php
                                                            foreach ($ingredients as $ingredient) {
                                                                echo '<option value="'.$ingredient->getId().'">'.$ingredient->getName().'</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </label>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th class="ingredientSelect">Zutat</th>
                                                <th class="ingredientAmount">Menge</th>
                                                <th class="ingredientUnit">Einheit</th>
                                            </tr>
                                            </thead>
                                            <tbody id="ingredientsTable">
                                            <tr class="targetIngredientRow d-none"></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="Zubereitung" class="form-label">Zubereitung</label>
                                    <textarea required class="form-control" id="Zubereitung" name="Zubereitung" rows="10" style="margin-left: 13px;width: 95%;"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button id="resetRecipeAddModal" type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
                            <button type="submit" class="btn btn-primary">Speichern</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <audio autoplay loop class="d-none immune-to-bop">
            <source src="../Video/Crazy_frog.mp3" type="audio/mpeg">
        </audio>
</body>
</html>