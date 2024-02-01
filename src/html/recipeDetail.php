<?php

include_once("../php/DBConnector.php");
include_once("../php/Rezept/rezept.php");
include_once("../php/Rezept/recipeIngedeans.php");

    $id = array_key_exists('id', $_REQUEST) ? $_REQUEST['id'] : '';

    $recipe = DBConnection::getRecipebyId($id);
    $zutaten = DBConnection::getIngredensByRecipeId($id);

?>


<div class="modal-header">
    <h5 class="modal-title" id="modalTitle"><?php echo $recipe->getName()?></h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <div>
        <p><?php echo $recipe->getDescription()?></p>
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
        <p><?php echo $recipe->getZubereitung()?></p>
    </div>
</div>