<div class="modal-header">
    <h5 class="modal-title" id="modalTitle">Zutat hinzufügen</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <div class="container">
        <div class="row mb-2">
            <div class="col">
                <label for="Zutat" class="form-label">Zutat</label>
                <input type="text" class="form-control" id="Zutat" name="Zutat">
            </div>
        </div>
        <div class="row mb-2">
            <div class="col">
                <label for="Menge" class="form-label">Menge</label>
                <input type="text" class="form-control" id="Menge" name="Menge">
            </div>
            <div class="col">
                <label for="Einheit" class="form-label">Einheit</label>
                <input type="text" class="form-control" id="Einheit" name="Einheit">
            </div>
        </div>
        <div class="row mb-2">
            <div class="col">
                <label for="Typ" class="form-label">Typ</label>
                <input type="text" class="form-control" id="Typ" name="Typ">
            </div>
        </div>
        <div class="row mb-2">
            <label for="Beschreibung" class="form-label">Beschreibung</label>
            <textarea class="form-control ms-2" id="Beschreibung" rows="3" style="width: 96%;"></textarea>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
    <button type="button" class="btn btn-primary">Speichern</button>
</div>