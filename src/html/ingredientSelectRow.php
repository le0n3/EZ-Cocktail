<?php
include_once("../php/DBConnector.php");
$ingredient = DBConnection::getIngredientById($_REQUEST['id']);

?>

<tr class="recipeIngredientRow">
    <td class="ingredientSelect d-none"><label class="w-100"><input disabled class="form-control" type="text" name="zutaten[<?php echo $ingredient->getId() ?>][id]" value="<?php echo $ingredient->getId() ?>"></label></td>
    <td class="ingredientSelect"><label class="w-100"><input disabled class="form-control" type="text" name="zutaten[<?php echo $ingredient->getName() ?>][zutatName]" value="<?php echo $ingredient->getName() ?>"></label></td>
    <td class="ingredientAmount"><label class="w-100"><input class="form-control" type="text" name="zutaten[<?php echo $ingredient->getId() ?>][menge]"></label></td>
    <td class="ingredientUnit"><label class="w-100"><input disabled class="form-control" type="text" name="zutaten[<?php echo $ingredient->getUnit() ?>][einheit]" value="<?php echo $ingredient->getUnit() ?>"></label></td>
</tr>
