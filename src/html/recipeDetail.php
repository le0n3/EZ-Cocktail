<?php

include_once("../php/DBConnector.php");
include_once("../php/Rezept/rezept.php");
include_once("../php/Rezept/recipeIngedeans.php");

    $id = array_key_exists('id', $_REQUEST) ? $_REQUEST['id'] : '';

    $recipe = DBConnection::getRecipebyId($id);
    $zutaten = DBConnection::getIngredensByRecipeId($id);

?>
<div>
    <p><?php echo $recipe->getName()?></p>
</div>
<div>
    <ul>
        <?php

            foreach ($zutaten as $zutat) {
                echo $zutat->GenerateBulletpoint();
            }
        ?>
    </ul>
</div>
<div>
    <p>zubereitung hier</p>
</div>