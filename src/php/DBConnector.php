<?php

include_once("Zutat/zutat.php");
include_once("Rezept/rezept.php");
class DBConnection
{
    private static string $servername = "localhost";
    private static string $dbname = "ez_cocktail";
    private static ?mysqli $connection = null;

    private static string $user = "root";
    private static string $password = "";

    /**
     * Get a database connection
     *
     * @return mysqli|null
     */
    public static function getConnection(): ?mysqli
    {
        if (self::$connection == null) {
            // Create connection
            self::$connection = new mysqli(self::$servername, self::$user, self::$password, self::$dbname);
            // Check connection
            if (self::$connection->connect_error) {
                die("Connection failed: " . self::$connection->connect_error);
            }
        }
        return self::$connection;
    }

    /**
     * Read filtered ingredients
     *
     * @param bool $withNull
     * @param string $name
     * @param string $menge
     * @param string $einheit
     * @param string $typ
     * @param string $beschreibung
     * @param string $orderBy
     * @param string $reihenfolge
     * @return array
     * @throws Exception
     */
    public static function readFiltertIngredient(bool $withNull = false,string $name = '',string $menge = '', string $einheit = '', string $typ = '', string $beschreibung= '', string $orderBy = 'name' , string $reihenfolge = 'asc'): array {

        $ingredients = [];

        // establish a connection
        $conn = self::getConnection();

        $nullString = $withNull ? "or menge is null" : "";

        // prepare statement to avoid SQL injection
        $stmt = $conn->prepare(
            "SELECT * FROM `zutatgesamt` 
             WHERE name LIKE CONCAT('%',?,'%') 
             AND (menge LIKE CONCAT('%',?,'%') ". $nullString." )  
             AND `einheit` LIKE CONCAT('%',?,'%') 
             AND typ LIKE CONCAT('%',?,'%') 
             AND beschreibung LIKE CONCAT('%',?,'%') 
             ORDER BY ". $orderBy." ". $reihenfolge.";"
        );

        if(!$stmt){
            throw new Exception('Error preparing statement');
        }

        // bind parameters
        $stmt->bind_param('sssss', $name, $menge, $einheit, $typ, $beschreibung);
        $stmt->execute();

        // get result
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $ingredients[] = new Ingredient($row["id"], $row["name"], $row["beschreibung"], array_key_exists('menge', $row) ? $row["menge"] ?? 0 : 0, $row["typ"], $row["einheit"], $row["einheitlang"]);
            }
        }

        return $ingredients;
    }

    /**
     * Read filtered ingredients how have No Quantety
     */
    public static function readIngredientWhithNoQuantety(): array {
        try {
            $ingredienz = array();
            $conn = self::getConnection();

            $sql = "SELECT * FROM `zutatgesamt` WHERE `menge` is Null";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Fügt alle gefundenen Zutaten zum Array hinzu
                while ($row = $result->fetch_assoc()) {
                    $ingredienz[] = new Ingredient($row["id"], $row["name"], $row["beschreibung"], 0, $row["typ"], $row["einheit"], $row["einheitlang"]);
                }
            }

        } catch (Exception) {
            // Liefert das leere Array zurück, wenn ein Fehler auftritt
            return $ingredienz;
        }
        // Rückgabe der gefundenen Zutaten
        return $ingredienz;
    }

    /**
     * Retrieves an ingredient from the database by its ID.
     *
     * @param string $id The ID of the ingredient.
     * @return Ingredient|null The Ingredient object if found, null otherwise.
     */
    public static function getIngredientById(string $id): ?Ingredient
    {
        try {
            // Get the database connection
            $conn = self::getConnection();

            // Prepare the SQL query
            $sql = "SELECT * FROM `zutatgesamt` WHERE id = ?";
            $stmt = $conn->prepare($sql);

            // Bind the id parameter to the SQL query
            $stmt->bind_param("i", $id);

            // Execute the query
            $stmt->execute();

            // Get the result set from the prepared statement
            $result = $stmt->get_result();

            // Check if there were results
            if ($result->num_rows > 0) {
                // Fetch the first (and supposedly only) result from the result set
                $row = $result->fetch_assoc();

                // Create a new Ingredient instance from the fetched data
                // Use the null coalescing operator (??) to provide default values for potentially missing data
                return new Ingredient(
                    $row["id"],
                    $row["name"],
                    $row["beschreibung"],
                    $row["menge"] ?? 0,
                    $row["typ"],
                    $row["einheit"],
                    $row["einheitlang"]
                );
            } else {
                // No Ingredient found for the provided ID
                return null;
            }
        } catch (Exception $e) {
            // Something went wrong, log the exception for debugging and return null
            error_log($e->getMessage());
            return null;
        }
    }

    /**
     * Fügt eine neue Zutat in der Datenbank hinzu.
     *
     * @param Ingredient $ingredient Das Zutat-Objekt, welches hinzugefügt wird.
     */
    public static function createIngredient(Ingredient $ingredient): void
    {
        // Überprüfen Sie, ob Zutat bereits in der Datenbank vorhanden ist.
        if(self::checkIfIngredientAlreadyExists($ingredient)){
            echo "Zutat ist bereits vorhanden, keine Aktion erforderlich.";
            return;
        }

        $conn = self::getConnection();
        $conn->begin_transaction();

        $queries = [
            "typ" => [
                "sql" => "IF (SELECT COUNT(*) FROM typ WHERE name = ?) = 0 THEN INSERT INTO typ (name) VALUES (?); END IF;",
                "types" => "ss",
                "params" => [$ingredient->getType(), $ingredient->getType()]
            ],
            "einheit" => [
                "sql" => "IF (SELECT COUNT(*) FROM einheit WHERE name = ?) = 0 THEN INSERT INTO einheit (name, einheitkuerzel) VALUES (?,?); END IF;",
                "types" => "sss",
                "params" => [$ingredient->getLongUnit(), $ingredient->getLongUnit(), $ingredient->getUnit()]
            ],
            "zutat" => [
                "sql" => "INSERT INTO zutat (name, beschreibung, typId, einheitId) VALUES (?, ?, (SELECT id FROM typ WHERE name = ?), (SELECT id FROM einheit WHERE name = ?));",
                "types" => "ssss",
                "params" => [$ingredient->getName(), $ingredient->getDescription(), $ingredient->getType(), $ingredient->getLongUnit()]
            ]
        ];

        foreach ($queries as $key => $query) {
            $stmt = $conn->prepare($query['sql']);

            if (!$stmt) {
                echo "Fehler bei der Vorbereitung des Statements für '$key'.";
                $conn->rollback();
                return;
            }

            $stmt->bind_param($query['types'], ...$query['params']);

            if (!$stmt->execute()) {
                echo "Fehler bei der Erstellung des Datensatzes: $stmt->error";
                $conn->rollback();
                return;
            }
        }
        $conn->commit();
    }

    /**
     * Aktualisiert die Zutatinformation in der Datenbank basierend auf dem übergebenen Ingredient-Objekt.
     *
     * @param Ingredient $ingredient Das zu aktualisierende Ingredient-Objekt.
     */
    public static function updateIngredient(Ingredient $ingredient): void
    {
        // Prüft, ob das Ingredient vorhanden ist.
        $check = self::getIngredientById($ingredient->getId());
        if($check == null) {
            echo "Das Ingredient ist nicht vorhanden.";
            return;
        }

        // Verbindung zur Datenbank.
        $conn = self::getConnection();
        $conn->begin_transaction();

        // SQL-Statements und Parameter.
        $queries = [
            "typ" => [
                "sql" => "IF (SELECT COUNT(*) FROM typ WHERE name = ?) = 0 THEN INSERT INTO typ (name) VALUES (?); END IF;",
                "types" => "ss",
                "params" => [$ingredient->getType(), $ingredient->getType()]
            ],
            "einheit" => [
                "sql" => "IF (SELECT COUNT(*) FROM einheit WHERE name = ?) = 0 THEN INSERT INTO einheit (name, einheitkuerzel) VALUES (?,?); END IF;",
                "types" => "sss",
                "params" => [$ingredient->getLongUnit(), $ingredient->getLongUnit(), $ingredient->getUnit()]
            ],
            "zutat" => [
                "sql" => "UPDATE `zutat` SET `name`= ?,`beschreibung`= ?, `typId`= (SELECT id from typ WHERE name = ?), `einheitId`= (SELECT id from einheit where einheit.name = ?)  WHERE `id` = ?",
                "types" => "ssssi",
                "params" => [$ingredient->getName(), $ingredient->getDescription(), $ingredient->getType(), $ingredient->getLongUnit(), $ingredient->getId()]
            ]
        ];

        // Durchläuft jedes Statement.
        foreach ($queries as $key => $query) {
            $stmt = $conn->prepare($query['sql']);

            if (!$stmt) {
                echo "Fehler beim Vorbereiten des Statements für '$key'.";
                $conn->rollback();
                return;
            }

            $stmt->bind_param($query['types'], ...$query['params']);

            if (!$stmt->execute()) {
                echo "Fehler beim Ausführen des Statements für '$key': $stmt->error";
                $conn->rollback();
                return;
            }

        }
        $conn->commit();
    }

    /**
     * Erstellt eine neue Menge von Zutaten in der Datenbank.
     *
     * @param int $zutatID Die ID der Zutat, für die die Menge erstellt wird.
     * @param int $newQuantety Die neue Menge der Zutat.
     */
    public static function createQuantityOfIngredients(int $zutatID, int $newQuantety): void
    {
        // Überprüfe, ob die Menge für die gegebene Zutat bereits existiert.
        // Wenn ja, breche die Funktion ab und gebe eine Benachrichtigung aus.
        if(self::checkIfQuantityAlreadyExists($zutatID)){
            echo "Menge für gegebene Zutat existiert bereits.";
            return;
        }

        // Stelle eine Verbindung zur Datenbank her.
        $conn = self::getConnection();

        // Bereite das SQL-Statement zum Einfügen der neuen Menge vor.
        $smt = $conn->prepare("INSERT INTO `zutatinventar`( `menge`, `zutatId`) VALUES (?,?)");

        // Wenn die Vorbereitung des Statements nicht erfolgreich war, gebe einen Fehler aus und breche die Funktion ab.
        if(!$smt){
            echo "Fehler bei der Vorbereitung des SQL-Statements.";
            return;
        }

        // Binde die Parameter an das vorbereitete Statement und führe es aus.
        $smt->bind_param("ii", $newQuantety, $zutatID);
        if(!$smt->execute()){
            echo "Fehler beim Erstellen des neuen Datensatzes: " . $smt->error;
            return;
        }

        // Wenn alles glattgelaufen ist, bestätige die erfolgreiche Operation.
        echo "Die Menge wurde erfolgreich erstellt.";
    }

    /**
     * Aktualisiert die Menge eines bestimmten Ingredients in der Datenbank.
     *
     * @param string $zutatID Die ID des Ingredients, dessen Menge aktualisiert wird.
     * @param string $newQuantety Die neue Menge des Ingredients.
     */
    public static function updateQuantityOfIngredients(string $zutatID, string $newQuantety): void
    {
        // Überprüfung, ob die Menge des Ingredients bereits existiert.
        if(!self::checkIfQuantityAlreadyExists($zutatID)){
            echo "Die Menge des gegebenen Ingredients existiert nicht.";
            return;
        }

        // Aufbau der Datenbankverbindung.
        $conn = self::getConnection();

        // Vorbereitung des SQL-Updates.
        $smt = $conn->prepare("UPDATE `zutatinventar` SET `menge`= ? WHERE `zutatId` = ?");

        // Überprüfung der erfolgreichen Statement-Vorbereitung.
        if(!$smt){
            echo "Fehler bei der Vorbereitung des SQL-Statements.";
            return;
        }

        // Binden der Parameter an das vorbereitete Statement.
        $smt->bind_param("ss", $newQuantety, $zutatID);
        if(!$smt->execute()){
            echo "Fehler bei der Aktualisierung des Datensatzes: " . $smt->error;
            return;
        }

        // Erfolgreiche Ausführung der Aktualisierung.
        echo "Die Menge wurde erfolgreich aktualisiert.";
    }

    /**
     * Liest alle Rezepte aus der Datenbank aus.
     *
     * @return array Ein Array von Recipe-Objekten.
     */
    public static function readAllRecipes(): array
    {
        // Initialisieren eines leeren Arrays zum Speichern der Rezepte.
        $recipes = array();

        try {
            // Aufbau der Datenbankverbindung.
            $conn = self::getConnection();

            // SQL-String zum Abfragen aller Einträge in der 'rezeptgesamt'-Tabelle.
            $sql = "SELECT * FROM `rezeptgesamt`";
            $result = $conn->query($sql);

            // Überprüfen, ob die Abfrage Ergebnisse zurückgegeben hat.
            if ($result->num_rows > 0) {
                // Durchlaufen der Ergebniszeilen ...
                while ($row = $result->fetch_assoc()) {
                    // ... und Hinzufügen jedes einzelnen Rezepts zum 'recipes'-Array.
                    $recipes[] = new Recipe($row["id"], $row["name"], $row["beschreibung"], $row["zubereitung"], $row["url"]);
                }
            }
        } catch (Exception $e) {  // Das Fangen von allgemeinen PHP Exceptions.
            // Im Falle eines Fehlers wird das bis jetzt gesammelte 'recipes'-Array zurückgegeben.
            echo "Ein Fehler ist aufgetreten: " . $e->getMessage();
            return $recipes;
        }

        // Rückgabe des 'recipes'-Array, wenn alles erfolgreich war.
        return $recipes;
    }

    /**
     * Gibt das Rezept aus der Datenbank zurück, das der gegebenen ID entspricht.
     *
     * @param string $id Die ID des gewünschten Rezepts.
     * @return Recipe Das gefundene Rezept oder ein leeres Rezept, wenn keine ID angegeben wurde.
     */
    public static function getRecipeById(string $id) : Recipe
    {
        // Erstelle ein leeres Rezept, welches zurückgegeben wird, sollte die ID leer sein.
        $recipe = new Recipe("", "", "", "", "");

        try {
            // Überprüfe, ob eine ID bereitgestellt wurde.
            if($id != '') {
                // Stelle eine Verbindung zur Datenbank her.
                $conn = self::getConnection();

                // Bereite die SQL-Abfrage vor.
                $sql = "SELECT * FROM `rezeptgesamt` WHERE id = ?";
                $stmt = $conn->prepare($sql);

                // Binden der Parameter an das vorbereitete Statement.
                $stmt->bind_param("s", $id);

                // Führe die Abfrage aus.
                $stmt->execute();

                // Speichert das Ergebnis der Abfrage.
                $result = $stmt->get_result();

                // Überprüft, ob die Abfrage Ergebnisse zurückgegeben hat.
                if ($result->num_rows > 0) {
                    // Erstelle ein neues Rezept-Objekt mit den Ergebnissen.
                    $row = $result->fetch_assoc();
                    $recipe = new Recipe($row["id"], $row["name"], $row["beschreibung"], $row["zubereitung"], $row["url"]);
                }
            }
        } catch (Exception $e) {  // Das Fangen von allgemeinen PHP Exceptions.
            // Im Falle eines Fehlers gibt eine Fehlermeldung aus.
            echo "Ein Fehler ist aufgetreten: " . $e->getMessage();
            // Gibt das bisher gesammelte Rezept zurück.
            return $recipe;
        }
        // Rückgabe des gefundenen Rezepts.
        return $recipe;
    }

    /**
     * Liefert eine Liste der Zutaten für ein bestimmtes Rezept aus der Datenbank.
     *
     * @param string $id Die ID des Rezepts, für das wir die Zutaten holen wollen.
     * @return array Ein Array, das die Zutaten für das angegebene Rezept enthält.
     */
    public static function getIngredientsByRecipeId(string $id): array
    {
        $recipeIngredients = array();

        // Prüfen Sie, ob die ID nicht leer ist.
        if($id != '') {
            try {
                // Stelle eine Verbindung zur Datenbank her.
                $conn = self::getConnection();

                // SQL-Anfrage zur Abrufung der Zutaten, die zum angegebenen Rezept gehören.
                $sql = "SELECT zutat_rezept.id, einheit.einheitkuerzel, zutat_rezept.menge, zutat.name, zutat.id as ZutatID 
                    FROM `zutat_rezept`
                    LEFT JOIN zutat ON zutat_rezept.zutatId = zutat.id
                    LEFT JOIN einheit ON zutat.einheitId = einheit.id
                    WHERE rezeptId = ?";

                // SQL-Anfrage vorbereiten und den Platzhalter mit der ID des Rezepts binden.
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('s', $id);
                $stmt->execute();

                // Das Ergebnis des SQL-Befehls ausführen und speichern.
                $result = $stmt->get_result();

                // Wenn das Ergebnis Zeilen enthält, durchlaufen Sie diese und fügen Sie diese zur Liste der Zutaten hinzu.
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $recipeIngredients[] = new RezeptZutaten($row["name"], $row["einheitkuerzel"], $row["menge"], $row["id"]);
                    }
                }
            } catch (Exception) {
                // Im Falle eines Fehlers gibt das leere Array zurück.
                return $recipeIngredients;
            }
        }
        return $recipeIngredients;
    }

    /**
     * Holt eine Liste von Rezepten aus der Datenbank, die alle Zutaten in ausreichender Menge in der Inventarliste haben.
     *
     * @return array Eine Liste der Rezepte, die auf der Grundlage der verfügbaren Zutaten erstellt werden können.
     */
    public static function getRecipesByIngredients(): array
    {
        $recipes = array();

        try {
            // Verbindung zur Datenbank herstellen.
            $conn = self::getConnection();

            // SQL-Anweisung, um Rezepte zu finden, die basierend auf den verfügbaren Zutaten im Inventar gemacht werden können.
            $sql = "SELECT *
                FROM rezeptgesamt 
                WHERE NOT EXISTS (
                    SELECT * FROM zutat_rezept
                    WHERE zutat_rezept.rezeptId = rezeptgesamt.id AND (
                        zutat_rezept.menge > (
                            SELECT zutatinventar.menge FROM zutatinventar
                            WHERE zutatinventar.zutatId = zutat_rezept.zutatId)
                        OR NOT EXISTS (
                            SELECT * FROM zutatinventar
                            WHERE zutatinventar.zutatId = zutat_rezept.zutatId))
                );";

            $result = $conn->query($sql);

            // Wenn die SQL-Anweisung Ergebnisse zurückgibt, holen Sie die Rezeptinformationen und füllen Sie das recipes Array.
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $recipes[] = new Recipe($row["id"], $row["name"], $row["beschreibung"], $row["zubereitung"], $row["url"]);
                }
            }

        } catch (Exception) {  // Abfangen allgemeiner PHP Exceptions.
            // Im Falle eines Fehlers wird ein leeres Array zurückgegeben.
            return $recipes;
        }
        return $recipes;
    }

    /**
     * Erstellt ein neues Rezept in der Datenbank, wenn es noch nicht existiert.
     *
     * @param Recipe $recipe Das Rezept, das in der Datenbank hinzugefügt werden soll.
     * @param array  $ingredients Die Zutaten, die dem Rezept zugeordnet werden sollen.
     */
    public static function createRecipe(Recipe $recipe, array $ingredients): void
    {
        // Prüfe, ob das Rezept bereits in der Datenbank existiert.
        if (self::checkIfRecipeAlreadyExists($recipe)){
            return;
        }

        // Verbindung zur Datenbank herstellen.
        $conn = self::getConnection();

        // SQL-Anweisung zur Erzeugung eines neuen Rezepts.
        $stmt = $conn->prepare("INSERT INTO `rezept`( `name`, `beschreibung`, `zubereitung`) VALUES (?,?,?);");

        if(!$stmt){
            echo "Fehler bei der Vorbereitung des SQL-Statements.";
            return;
        }

        // Werte für das vorbereitete SQL-Statement setzen.
        $name = $recipe->getName();
        $description = $recipe->getDescription();
        $preparation = $recipe->getZubereitung();

        // Werte an das vorbereitete Statement binden und es ausführen.
        $stmt->bind_param("sss", $name, $description, $preparation);

        if(!$stmt->execute()){  // Im Fehlerfall eine Fehlermeldung ausgeben.
            echo "Fehler beim Erstellen des Rezepts: ". $stmt->error;
            return;
        }

        // SQL-Anweisung zur Hinzufügung eines Bildes zum Rezept.
        $stmt = $conn->prepare("INSERT INTO rezeptbild (rezeptbild.rezeptId, rezeptbild.url) VALUES ((SELECT id FROM rezept WHERE name = ?), ?);");

        if(!$stmt){
            echo "Fehler bei der Vorbereitung des SQL-Statements.";
            return;
        }

        // Werte binden und ausführen.
        $url = $recipe->getUrl();
        $stmt->bind_param("ss", $name, $url);

        if(!$stmt->execute()){
            echo "Fehler beim Hinzufügen des Bildes zum Rezept: ". $stmt->error;
            return;
        }

        // SQL-Anweisung zur Hinzufügung der Zutaten zum Rezept.
        $query = "INSERT INTO `zutat_rezept`(`menge`, `rezeptId`, `zutatId`) VALUES (?, (SELECT id FROM rezept WHERE rezept.name = ?), (SELECT id FROM zutat WHERE zutat.name = ?))";
        $stmt = $conn->prepare($query);

        // Starte eine Transaktion.
        $conn->begin_transaction();

        try {
            // Füge jede Zutat zum Rezept in der Datenbank hinzu.
            foreach ($ingredients as $ingredient) {
                $stmt->bind_param("iss", $ingredient->getAmount(), $name, $ingredient->getZutat());
                $stmt->execute();
            }

            $conn->commit();  // Änderungen in der Datenbank speichern.

        } catch (Exception $e) {
            $conn->rollback();  // Bei Fehlern, alle Änderungen rückgängig machen.
            echo "Fehler beim Hinzufügen der Zutaten zum Rezept: " . $e->getMessage();
            return;
        }
    }

    /**
     * Aktualisiert die Menge an Zutaten in der Inventardatenbank, nachdem ein Rezept durchgeführt wurde.
     *
     * @param int $RecepieID Die ID des durchgeführten Rezepts.
     */
    public static function recipeDone(int $RecepieID): void
    {
        // Stelle eine Verbindung zur Datenbank her.
        $conn = self::getConnection();
        $conn->begin_transaction();

        // Holen Sie die Zutaten des durchgeführten Rezepts.
        $ingredients = self::getIngredientsByRecipeId($RecepieID);

        // Gehe durch jede Zutat des Rezepts.
        foreach ($ingredients as $ingredient){
            // Bereite das SQL-Statement für die Aktualisierung der Zutatenmenge im Inventar vor.
            $stmt = $conn->prepare("UPDATE `zutatinventar` SET `menge`=(SELECT zutatinventar.menge From zutatinventar WHERE id = ?) - ? WHERE `id` = ?");

            // Wenn das SQL-Statement nicht vorbereitet werden konnte, gebe einen Fehler aus.
            if(!$stmt) {
                echo "Fehler bei der Vorbereitung des SQL-Statements.";
                $conn->rollback();
                return;
            }

            // Binde die ID und die Menge der Zutat an das vorbereitete Statement.
            $id = $ingredient->getId();
            $amount = $ingredient->getAmount();
            $stmt->bind_param("iii", $id, $amount, $id);

            // Führe das SQL-Statement aus. Bei Fehlern wird eine entsprechende Fehlermeldung ausgegeben.
            if(!$stmt->execute()) {
                echo "Fehler beim Aktualisieren der Datenbank: ". $stmt->error;
                $conn->rollback();
                return;
            }
        }

        $conn->commit();
    }

    /**
     * Überprüft, ob das angegebene Ingredient bereits in der Datenbank existiert.
     *
     * @param Ingredient $ingredient Das zu überprüfende Ingredient-Objekt.
     * @return bool Gibt true zurück, wenn das Ingredient bereits existiert, ansonsten false.
     */
    private static function checkIfIngredientAlreadyExists(Ingredient $ingredient) : bool
    {
        try {
            // Stelle eine Verbindung zur Datenbank her.
            $conn = self::getConnection();

            // Bereite die SQL-Abfrage vor: Überprüft, ob ein Ingredient mit dem gleichen Namen bereits existiert.
            $sql = "SELECT * FROM `zutatgesamt` WHERE `name` = ?";
            $stmt = $conn->prepare($sql);

            // Binde den Ingredient-Namen als Parameter an das vorbereitete Statement.
            $name = $ingredient->getName();
            $stmt->bind_param("s", $name);

            // Führe die Abfrage aus.
            $stmt->execute();

            // Speichert das Ergebnis der Abfrage.
            $result = $stmt->get_result();

            // Überprüft, ob die Abfrage Ergebnisse zurückgegeben hat, wenn ja, dann existiert das Ingredient schon in der Datenbank.
            if ($result->num_rows > 0) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {  // Das Fangen von allgemeinen PHP Exceptions.
            // Wenn ein Fehler auftritt, logge diesen.
            error_log("Ein Fehler ist aufgetreten: " . $e->getMessage());

            // Gehe davon aus, dass das Ingredient nicht existiert, wenn ein Fehler auftritt.
            return false;
        }
    }

    /**
     * Überprüft, ob eine bestimmte Menge einer Zutat bereits in der Datenbank existiert.
     *
     * @param int $ZutatID Die ID der Zutat, die überprüft werden soll.
     * @return bool True, wenn die Menge der Zutat bereits existiert, sonst False.
     */
    private static function checkIfQuantityAlreadyExists(int $ZutatID) : bool
    {
        try {
            // Stelle eine Verbindung zur Datenbank her.
            $conn = self::getConnection();

            // Definiere das SQL-Statement, dass überprüft,
            // ob eine Menge einer bestimmten Zutat (basierend auf deren ID) existiert.
            $sql = "SELECT `id` FROM `zutatinventar` WHERE `zutatId` = ?";

            // Bereite das SQL-Statement vor.
            $stmt = $conn->prepare($sql);

            // Binde die Zutat ID an das vorbereitete Statement und führe es aus.
            $stmt->bind_param("i", $ZutatID);
            $stmt->execute();

            // Hole die Ergebnisse der Anfrage.
            $result = $stmt->get_result();

            // Wenn die Anfrage Ergebnisse zurückgibt, dann gibt die Funktion true zurück,
            // weil die Menge dieser Zutat bereits existiert.
            if ($result->num_rows > 0) {
                return true;
            } else {
                // Andernfalls gibt die Funktion false zurück, da die Menge diese Zutat noch nicht existiert.
                return false;
            }
        } catch (Exception $e) {  // Fangen von allgemeinen PHP Exceptions.
            // Wenn ein Fehler auftritt, gebe eine Fehlermeldung aus.
            echo "Ein Fehler ist aufgetreten: " . $e->getMessage();

            // Die Funktion gibt false zurück, da die Prüfung aufgrund eines Fehlers nicht abgeschlossen wurde.
            return false;
        }
    }


    /**
     * Überprüft, ob das angegebene Rezept bereits in der Datenbank existiert.
     *
     * @param Recipe $rezept Das Rezept, das überprüft werden soll.
     * @return bool True, wenn das Rezept bereits existiert, sonst False.
     */
    private static function checkIfRecipeAlreadyExists(Recipe $rezept) : bool
    {
        try {
            // Stelle eine Verbindung zur Datenbank her.
            $conn = self::getConnection();

            // Bereite die SQL-Abfrage vor: Wir prüfen, ob ein Rezept mit dem gleichen Namen existiert.
            $sql = "SELECT * FROM `rezeptgesamt` WHERE `name`  = ?";
            $stmt = $conn->prepare($sql);

            // Binde den Namen des Rezepts als Parameter an das vorbereitete Statement.
            $name = $rezept->getName();
            $stmt->bind_param("s", $name);

            // Führe die Abfrage aus.
            $stmt->execute();

            // Holt das Ergebnis der Abfrage.
            $result = $stmt->get_result();

            // Wenn die Abfrage Ergebnisse zurückgibt, bedeutet das, dass das Rezept bereits existiert.
            if ($result->num_rows > 0) {
                return true;
            } else {
                return false ;
            }
        } catch (Exception $e) {  // Das Fangen von allgemeinen PHP Exceptions.
            // Im Falle eines Fehlers gibt eine Fehlermeldung aus.
            echo "Ein Fehler ist aufgetreten: " . $e->getMessage();

            // Gehe davon aus, dass das Rezept nicht existiert, wenn ein Fehler auftritt.
            return false ;
        }
    }
}
