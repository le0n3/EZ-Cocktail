<?php
// hier anhand einer zutatId die werte für Einheiten usw anzeigen, aber disabled lassen
include_once("../php/DBConnector.php");
$myIngredient = null;
    if(array_key_exists('id', $_REQUEST)){
        $myIngredient = DBConnection::getIngredientById($_REQUEST['id']);
    }
    $IngredientsWHithNULL = DBConnection::readFiltertngredient( true);

?>

<form action="../php/ManipulteMyIngredients.php" autocomplete="off" method="post">
    <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">Zutat hinzufügen</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="container">
                <?php if ($myIngredient != null) {
                    echo '<input type="hidden" name="MeineZutatId" value="'.$_REQUEST['id'].'">';
                } ?>
                <div class="container">
                    <div class="row mb-2">
                        <div class="col">
                            <label for="zutatId" class="form-label">Zutat</label>
                            <select class="form-control" id="zutatId" name="zutatId">
                                <?php
                                //Das ist mist so komme ich nicht an die Zutat ID und ich kann den Wahl schalter nicht auslehsen den ich zwingend für das neu erstellen brauche zudem muss die Id ü
                                foreach($IngredientsWHithNULL as $ingredient)
                                {?>

                                    <option value="<?php echo $ingredient->getIngredient(); ?>"><?php echo $ingredient->getIngredient(); ?></option>

                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <label for="Menge" class="form-label">Menge</label>
                            <input type="text" class="form-control" id="Menge" name="Menge" value="<?php echo !is_null($myIngredient) ? $myIngredient->getQuantity(): ''; ?>">
                        </div>
                    </div>
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
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
                    <button type="submit" class="btn btn-primary">Speichern</button>
                </div>
        </div>
    </div>
</form>