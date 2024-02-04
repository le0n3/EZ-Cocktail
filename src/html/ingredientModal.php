<?php
include_once("../php/DBConnector.php");
$ingredeant = null;
    if(array_key_exists('id', $_REQUEST)){
        $ingredeant = DBConnection::getIngredientById($_REQUEST['id']);

    }
?>


<div class="modal-header">
    <h5 class="modal-title" id="modalTitle">Zutat hinzufügen</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <div class="container">
        <div class="row mb-2">
            <div class="col">
                <label for="Zutat" class="form-label">Zutat</label>
                <input type="text" class="form-control" id="Zutat" name="Zutat" value="<?php echo !is_null($ingredeant) ? $ingredeant->getIngredient(): ''; ?>">
            </div>
        </div>
        <div class="row mb-2">
            <div class="col">
                <label for="Menge" class="form-label">Menge</label>
                <input type="text" class="form-control" id="Menge" name="Menge" value="<?php echo !is_null($ingredeant) ? $ingredeant->getQuantity(): ''; ?>">
            </div>
            <div class="col">
                <label for="EinheitKürzel" class="form-label">Einheit Kürzel</label>
                <input type="text" class="form-control" id="EinheitKürzel" name="EinheitKürzel">
            </div>
            <div class="col">
                <label for="Einheit" class="form-label">Einheit</label>
                <input type="text" class="form-control" id="Einheit" name="Einheit" value="<?php echo !is_null($ingredeant) ? $ingredeant->getUnit(): ''; ?>">
            </div>
        </div>
        <div class="row mb-2">
            <div class="col">
                <label for="Typ" class="form-label">Typ</label>
                <input type="text" class="form-control" id="Typ" name="Typ" value="<?php echo !is_null($ingredeant) ? $ingredeant->getType(): ''; ?>">
            </div>
        </div>
        <div class="row mb-2">
            <label for="Beschreibung" class="form-label">Beschreibung</label>
            <textarea class="form-control ms-2" id="Beschreibung" rows="3" style="width: 96%;"> <?php echo !is_null($ingredeant) ? $ingredeant->getDescription(): ''; ?></textarea>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
    <button type="button" class="btn btn-primary">Speichern</button>
</div>