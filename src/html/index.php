<?php
include_once("../php/DBConnector.php");

$filterName= ''; $filterMenge= ''; $filterEinheit= ''; $filterTyp= ''; $filterBeschreibung = '';
$sort = $_REQUEST['sort'] ?? ['sort' => 'name', 'order' => 'asc'];
$sortName = $sort['sort'] != "" ? $sort['sort']: "name"  ;
$sortOrder = $sort['order'] != "" ? $sort['order']: "desc";

if (array_key_exists("filter",$_REQUEST)){

    $filter = $_REQUEST['filter'] ;
    $filterName = array_key_exists("Name",$filter) ? $filter['Name'] : "";

    $filterEinheit = array_key_exists("Einheit", $filter) ? $filter['Einheit'] : "";
    $filterTyp = array_key_exists("Typ", $filter) ? $filter['Typ']: "";
    $filterBeschreibung = array_key_exists("Beschreibung", $filter) ? $filter['Beschreibung']: "";
}
$Ingredients = DBConnection::readFiltertngredient($filterName, "", $filterEinheit, $filterTyp, $filterBeschreibung, $sortName, $sortOrder);
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

    <!-- Custom JS -->
      <script src="../js/index.js"></script>
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
                <span class="ms-4">Alle Zutaten</span>
            </a>
        </div>
      </nav>
    <div class="main">
        <div class="d-flex flex-column flex-shrink-0 bg-light vh-100">
            <ul class="nav nav-pills nav-flush flex-column mb-auto text-center sticky-top top-0">
              <li class="nav-item">
                <a href="index.php" class="nav-link active py-3 border-bottom" aria-current="page" title="Alle Zutaten" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Alle Zutaten">
                    <span class="icon icon-grocery"></span>
                </a>
              </li>
                <li class="nav-item">
                    <a href="myIngredients.php" class="nav-link py-3 border-bottom" aria-current="page" title="Meine Zutaten" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Meine Zutaten">
                        <span class="icon icon-grocery"></span>
                    </a>
                </li>
              <li>
                <a href="allRecipes.php" class="nav-link py-3 border-bottom" title="Alle Rezepte" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Alle Rezepte">
                    <span class="icon icon-format_list_bulleted"></span>
                </a>
              </li>
              <li>
                <a href="myRecipes.php" class="nav-link py-3 border-bottom" title="Mögliche Rezepte" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Mögliche Rezepte">
                    <span class="icon icon-checklist"></span>
                </a>
              </li>
            </ul>
          </div>
          <div class="table-container w-100 m-5 shadow rounded">
            <table class="table bg-body table-striped">
                <form action="?" autocomplete="off" id="main-table" method="get">
                    <div class="d-none"><input type="hidden" name="sort[sort]" id="sort-filter"></div>
                    <div class="d-none"><input type="hidden" name="sort[order]" id="order-filter"></div>
                    <thead class="bg-light sticky-top top-0">
                    <tr>
                        <th scope="col"><span class="icon icon-add_circle" title="Eintrag hinzufügen" id="addIngredient" data-bs-toggle="modal" data-bs-target="#ingredientModal"></span></th>
                        <th scope="col" class="table-name">
                            <span>Name</span>
                            <span class="icon
                                  <?php if ($sort['sort'] == 'name') {
                                            if ($sort['order'] == 'asc') {
                                                echo 'icon-expand_more';
                                            } else {
                                                echo 'icon-expand_less';
                                            }
                                        } else {
                                            echo 'icon-unfold_more';
                                        }
                                    ?>
                                  sort-submit"
                                  data-sort="name"
                                  data-order="<?php if($sort['sort'] == 'name') {
                                                    if ($sort['order'] == 'asc') {
                                                        echo 'desc';
                                                    } else {
                                                        echo "asc";
                                                    }
                                  }else  {
                                      echo 'desc';
                                  } ?>">
                            </span>
                        </th>
                        <th scope="col" class="table-unit">
                            <span>Einheit</span>
                            <span class="icon
                                  <?php if ($sort['sort'] == 'einheit') {
                                            if ($sort['order'] == 'asc') {
                                                echo 'icon-expand_more';
                                            } else {
                                                echo 'icon-expand_less';
                                            }
                                        } else {
                                            echo 'icon-unfold_more';
                                        }
                                        ?>
                                  sort-submit"
                                  data-sort="einheit"
                                  data-order="<?php if($sort['sort'] == 'einheit') {
                                                    if ($sort['order'] == 'asc') {
                                                        echo 'desc';
                                                    } else {
                                                        echo "asc";
                                                    }
                                                }else  {
                                      echo 'desc';
                                  } ?>">
                            </span>
                        </th>
                        <th scope="col" class="table-type">
                            <span>Typ</span>
                            <span class="icon
                                  <?php if ($sort['sort'] == 'typ') {
                                        if ($sort['order'] == 'asc') {
                                            echo 'icon-expand_more';
                                        } else {
                                            echo 'icon-expand_less';
                                        }
                                    } else {
                                        echo 'icon-unfold_more';
                                    }
                                    ?>
                                  sort-submit"
                                  data-sort="typ"
                                  data-order="<?php if($sort['sort'] == 'typ') {
                                                    if ($sort['order'] == 'asc') {
                                                        echo 'desc';
                                                    } else {
                                                        echo "asc";
                                                    }
                                              }else  {
                                      echo 'desc';
                                  }?>">
                            </span>
                        </th>
                        <th scope="col" class="table-final-col">
                            <span>Beschreibung</span>
                            <span class="icon
                                  <?php if ($sort['sort'] == 'beschreibung') {
                                            if ($sort['order'] == 'asc') {
                                                echo 'icon-expand_more';
                                            } else {
                                                echo 'icon-expand_less';
                                            }
                                        } else {
                                            echo 'icon-unfold_more';
                                        }
                                        ?>
                                  sort-submit"
                                  data-sort="beschreibung"
                                  data-order="<?php if($sort['sort'] == 'beschreibung') {
                                                    if ($sort['order'] == 'asc') {
                                                        echo 'desc';
                                                    } else {
                                                        echo "asc";
                                                    }
                                              }else  {
                                      echo 'desc';
                                  }?>">
                            </span>
                        </th>
                    </tr>
                    <tr>
                        <th scope="col" class="table-icon">
                            <a href="index.php"><span class="icon icon-close top-1" title="Filter entfernen"></span></a>
                        </th>
                        <th scope="col" class="table-name"><input type="text" name="filter[Name]" value="<?php echo $filterName; ?>"></th>
                        <th scope="col" class="table-unit"><input type="text" name="filter[Einheit]" value="<?php echo $filterEinheit; ?>"></th>
                        <th scope="col" class="table-type"><input type="text" name="filter[Typ]" value="<?php echo $filterTyp; ?>"></th>
                        <th scope="col" class="table-final-col"><input type="text" name="filter[Beschreibung]" value="<?php echo $filterBeschreibung; ?>"></th>
                    </tr>
                    </thead>
                </form>

                <tbody>

                <?php

                foreach($Ingredients as $ingredient)
                {?>

                    <tr>
                        <td class="table-icon" title="Eintrag bearbeiten"><span class="icon icon-edit editIngredient" data-bs-toggle="modal" data-bs-target="#ingredientModal" data-id='<?php echo $ingredient->getId(); ?>'></span></td>
                        <td class="table-name" title="<?php echo $ingredient->getIngredient(); ?>"><span><?php echo $ingredient->getIngredient(); ?></span></td>
                        <td class="table-unit" title="<?php echo $ingredient->getUnit(); ?>"><span><?php echo $ingredient->getUnit(); ?></span></td>
                        <td class="table-type" title="<?php echo $ingredient->getType(); ?>"><span><?php echo $ingredient->getType(); ?></span></td>
                        <td class="table-description" title="<?php echo $ingredient->getDescription(); ?>"><span><?php echo $ingredient->getDescription(); ?></span></td>
                    </tr>

                <?php
                }

                ?>
                </tbody>
              </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="ingredientModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="detailInfo">
            </div>
        </div>
    </div>
   </body>
</html>