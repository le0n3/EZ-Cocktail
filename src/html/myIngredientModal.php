<?php
// hier anhand einer zutatId die werte für Einheiten usw anzeigen, aber disabled lassen
include_once("../php/DBConnector.php");
$myIngredient = null;
    if(array_key_exists('MeineZutatId', $_REQUEST)){
        //muss prüfen ob eine myId gesetzt ist, statt rezeptId
        $myIngredient = DBConnection::getMyIngredientById($_REQUEST['MeineZutatId']);
    }
?>


<form action="../php/ManipulteMyIngredients.php" autocomplete="off" method="post">
    <?php if ($myIngredient != null) {
        echo '<input type="hidden" name="MeineZutatId" value="'.$_REQUEST['MeineZutatId'].'">';
    } ?>

        <div class="container">
            <div class="row mb-2">
                <div class="col">
                    <label for="EinheitKürzel" class="form-label">Einheit Kürzel</label>
                    <input disabled type="text" class="form-control" id="EinheitKürzel" name="EinheitKürzel">
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
        </div>
    <div class="modal-footer">
        <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
        <button type="submit" class="btn btn-primary">Speichern</button>
    </div>
</form>