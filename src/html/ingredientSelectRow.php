<?php
include_once("../php/DBConnector.php");
$ingredients = DBConnection::readFiltertngredient(true);
?>
    <td class="ingredientSelect">
        <label class="w-100">
            <select name="zutaten[id][]" class="form-select ingredientSelectElement">
                <option selected disabled>Bitte wählen</option>
                <?php
                foreach ($ingredients as $ingredient) {
                    echo '<option value="'.$ingredient->getId().'" data-unit="'.$ingredient->getUnit().'">'.$ingredient->getIngredient().'</option>';
                }
                ?>
            </select>
        </label>
    </td>
    <td class="ingredientAmount"><label class="w-100"><input class="form-control" type="text" name="zutaten[menge][]"></label></td>
    <td class="ingredientUnit"><label class="w-100"><input class="form-control" type="text" name="zutaten[einheit][]"></label></td>