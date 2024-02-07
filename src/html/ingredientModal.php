<?php
include_once("../php/DBConnector.php");
$ingredient = null;
    if(array_key_exists('id', $_REQUEST)){
        $ingredient = DBConnection::getIngredientById($_REQUEST['id']);
    }
?>


<form action="../php/ManipulteIngredients.php" autocomplete="off" method="post">
    <?php if ($ingredient != null) {
        echo '<input type="hidden" name="id" value="'.$_REQUEST['id'].'">';
    } ?>
    <div class="modal-header">
        <h5 class="modal-title" id="modalTitle"><?php echo !is_null($ingredient) ? 'Zutat bearbeiten': 'Zutat hinzufügen'; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="container">
            <div class="row mb-2">
                <div class="col">
                    <label for="Zutat" class="form-label">Zutat</label>
                    <input type="text" class="form-control" id="Zutat" name="Zutat" value="<?php echo !is_null($ingredient) ? $ingredient->getName(): ''; ?>">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col">
                    <label for="EinheitKürzel" class="form-label">Einheit Kürzel</label>
                    <input type="text" class="form-control" id="EinheitKürzel" name="EinheitKürzel" value="<?php echo !is_null($ingredient) ? $ingredient->getLongUnit(): ''; ?>">
                </div>
                <div class="col">
                    <label for="Einheit" class="form-label">Einheit</label>
                    <input type="text" class="form-control" id="Einheit" name="Einheit" value="<?php echo !is_null($ingredient) ? $ingredient->getUnit(): ''; ?>">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col">
                    <label for="Typ" class="form-label">Typ</label>
                    <input type="text" class="form-control" id="Typ" name="Typ" value="<?php echo !is_null($ingredient) ? $ingredient->getType(): ''; ?>">
                </div>
            </div>
            <div class="row mb-2">
                <label for="Beschreibung" class="form-label">Beschreibung</label>
                <textarea class="form-control ms-2" id="Beschreibung" name="Beschreibung" rows="3" style="width: 96%;"> <?php echo !is_null($ingredient) ? $ingredient->getDescription(): ''; ?></textarea>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
        <button type="submit" class="btn btn-primary">Speichern</button>
    </div>
</form>