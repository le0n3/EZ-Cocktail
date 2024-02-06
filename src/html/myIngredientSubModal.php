<?php
include_once("../php/DBConnector.php");
$ingredient = null;
if (array_key_exists('id', $_REQUEST)) {
    $myIngredient = DBConnection::getIngredientById($_REQUEST['id']);
}

?>

<div class="row mb-2">
<div class="col">
    <label for="EinheitKürzel" class="form-label">Einheit Kürzel</label>
    <input disabled type="text" class="form-control" id="EinheitKürzel" name="EinheitKürzel" value="<?php echo !is_null($myIngredient) ? $myIngredient->getLongUnit(): ''; ?>">
</div>
<div class="col">
    <label for="Einheit" class="form-label">Einheit</label>
    <input disabled type="text" class="form-control" id="Einheit" name="Einheit" value="<?php echo !is_null($myIngredient) ? $myIngredient->getUnit(): ''; ?>">
</div>
</div>
<div class="row mb-2">
    <div class="col">
        <label for="Typ" class="form-label">Typ</label>
        <input disabled type="text" class="form-control" id="Typ" name="Typ" value="<?php echo !is_null($myIngredient) ? $myIngredient->getType(): ''; ?>">
    </div>
</div>
<div class="row mb-2">
    <label for="Beschreibung" class="form-label">Beschreibung</label>
    <textarea disabled class="form-control ms-2" id="Beschreibung" name="Beschreibung" rows="3" style="width: 96%;"> <?php echo !is_null($myIngredient) ? $myIngredient->getDescription(): ''; ?></textarea>
</div>
