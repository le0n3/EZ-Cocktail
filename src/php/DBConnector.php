<?php

include_once("Zutat/zutat.php");
include_once("Rezept/rezept.php");
class DBConnection
{
    private static $servername = "localhost";
    private static $dbname = "ez_cocktail";
    private static $connection = null;

    private static $user = "root";
    private static $password = "";

    public static function getConnection()
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

    public static function readFiltertngredient(bool $WhithNULL ,String $Name = "", String $Menge = "", String $Einheit = "", String $Typ ="", String $Beschribung= "", String $OrderBy = "" , String $Reinfolge = "asc"): array
    {
        try {

            $ingredienz = array();
            $conn = self::getConnection();
if ($WhithNULL){
    $nullstring = "or menge is null";

}else {
    $nullstring = "";
}
            $sql = "SELECT * FROM `zutatgesamt` where name LIKE '%". $Name."%' and (menge LIKE '%". $Menge."%' ". $nullstring." )  and `einheit` LIKE '%". $Einheit."%' and typ LIKE '%". $Typ."%' and beschreibung LIKE '%". $Beschribung."%' ORDER BY ". $OrderBy." ". $Reinfolge.";";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {

                while ($row = $result->fetch_assoc()) {

                    array_push($ingredienz, new Ingredient($row["id"], $row["name"], $row["beschreibung"],array_key_exists('menge', $row)? $row["menge"]?? 0 : 0, $row["typ"], $row["einheit"], $row["einheitlang"]));
                }
            }

        } catch (Exception $e) {
            return $ingredienz;
        }
        return $ingredienz;
    }

    public static function getIngredientById($id)
    {
        try {
            $conn = self::getConnection();
            $sql = "SELECT * FROM `zutatgesamt` WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return new Ingredient($row["id"], $row["name"], $row["beschreibung"], array_key_exists('menge', $row) ? $row["menge"] ?? 0 : 0, $row["typ"], $row["einheit"], $row["einheitlang"]);
            } else {
                return null;
            }
        } catch (Exception $e) {
            return null;
        }
    }

    public static function createIngredient(Ingredient $ingredeant) {
        if(self::CheckIfZutatAllreadyExists($ingredeant)){
            return;
        }

        $conn = self::getConnection();

        $smt = $conn->prepare("IF (SELECT COUNT(*) FROM typ WHERE name = ?) = 0 THEN 
                    INSERT INTO typ (name) VALUES (?);
                END IF;");

        if(!$smt){
            echo "Error Prepareing Statment ";
            return;
        }

        $var1 = $ingredeant->getType();

        $smt->bind_param("ss", $var1, $var1);
        if(!$smt->execute()){
            echo "Error Creating record ". $smt->error;
            return;
        }


        $smt2 = $conn->prepare("IF (SELECT COUNT(*) FROM einheit WHERE name = ?) = 0 THEN
                    INSERT INTO einheit (name, einheitkuerzel) VALUES (?,?);
                END IF;");

        if(!$smt2){
            echo "Error Prepareing Statment ";
            return;
        }

        $var1 = $ingredeant->getLongUnit();
        $var2 = $ingredeant->getUnit();


        $smt2->bind_param("sss", $var1, $var1, $var2);
        if(!$smt2->execute()){
            echo "Error Creating record ". $smt2->error;
            return;
        }

        $smt3 = $conn->prepare("insert into zutat ( name, beschreibung, typId, einheitId) values (?,?,
                                                                  (Select id from typ where typ.name =?),
                                                                  (Select id from einheit where einheit.name = ?));");
        if(!$smt3){
            echo "Error Prepareing Statment ";
            return;
        }

        $var1= $ingredeant->getIngredient();
        $var2 = $ingredeant->getDescription();
        $var3 = $ingredeant->getType();
        $var4 = $ingredeant->getLongUnit();

        $smt3->bind_param("ssss", $var1, $var2, $var3, $var4);

        if(!$smt3->execute()){
            echo "Error Creating record ". $smt3->error;
            return;
        }

    }

    public  static function updateIngredient(Ingredient $ingredeant)
    {
        $check = self::getIngredientById($ingredeant->getId());
        if($check == null){
            return;
        }

        $conn = self::getConnection();

        $smt = $conn->prepare("IF (SELECT COUNT(*) FROM typ WHERE name = ?) = 0 THEN 
                    INSERT INTO typ (name) VALUES (?);
                END IF;");

        if(!$smt){
            echo "Error Prepareing Statment ";
            return;
        }

        $var1 = $ingredeant->getType();

        $smt->bind_param("ss", $var1, $var1);
        if(!$smt->execute()){
            echo "Error Creating record ". $smt->error;
            return;
        }


        $smt2 = $conn->prepare("IF (SELECT COUNT(*) FROM einheit WHERE name = ?) = 0 THEN
                    INSERT INTO einheit (name, einheitkuerzel) VALUES (?,?);
                END IF;");

        if(!$smt2){
            echo "Error Prepareing Statment ";
            return;
        }

        $var1 = $ingredeant->getLongUnit();
        $var2 = $ingredeant->getUnit();


        $smt2->bind_param("sss", $var1, $var1, $var2);
        if(!$smt2->execute()){
            echo "Error Creating record ". $smt2->error;
            return;
        }

        $smt3 = $conn->prepare("UPDATE `zutat` SET `name`= ?,`beschreibung`= ?,
                   `typId`=  (Select id from typ where typ.name = ?),
                    `einheitId`=(Select id from einheit where einheit.name = ?)  WHERE `id` = ?");
        if(!$smt3){
            echo "Error Prepareing Statment ";
            return;
        }

        $var1= $ingredeant->getIngredient();
        $var2 = $ingredeant->getDescription();
        $var3 = $ingredeant->getType();
        $var4 = $ingredeant->getId();
        $var5 = $ingredeant->getLongUnit();

        $smt3->bind_param("ssssi", $var1, $var2, $var3, $var5, $var4);

        if(!$smt3->execute()){
            echo "Error Creating record ". $smt3->error;
            return;
        }

    }

    public static function createQuantetyOffIngerdeans(int $zutatID, int $newQuantety)
    {
        if(self::CheckIFQuanteteyAllreadyExists($zutatID)){
            return;
        }

        $conn = self::getConnection();

        $smt = $conn->prepare("INSERT INTO `zutatinventar`( `menge`, `zutatId`) VALUES (?,?)");

        if(!$smt){
            echo "Error Prepareing Statment ";
            return;
        }

        $smt->bind_param("si", $newQuantety, $zutatID);
        if(!$smt->execute()){
            echo "Error Creating record ". $smt->error;
            return;
        }

    }

    public static function uptareQuantetyOffIngerdeans(int $zutatID, int $newQuantety)
    {

        if(!self::CheckIFQuanteteyAllreadyExists($zutatID)){
            return;
        }

        $conn = self::getConnection();

        $smt = $conn->prepare("UPDATE `zutatinventar` SET `menge`= ? WHERE `zutatId` = ?");

        if(!$smt){
            echo "Error Prepareing Statment ";
            return;
        }

        $smt->bind_param("ii", $newQuantety, $zutatID);
        if(!$smt->execute()){
            echo "Error Creating record ". $smt->error;
            return;
        }

    }

    public static function readAllRecipes()
    {
        try {

            $recipes = array();
            $conn = self::getConnection();

            $sql = "SELECT * FROM `rezeptgesamt`";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {

                while ($row = $result->fetch_assoc()) {
                    array_push($recipes, new Recipe($row["id"], $row["name"], $row["beschreibung"], $row["zubereitung"], $row["url"]));
                }
            }

        } catch (Exception $e) {
            return $recipes;
        }
        return $recipes;
    }

    public static function getRecipebyId(String $id) : Recipe
    {
        try {
            if($id != '') {
                $recipe = null;
                $conn = self::getConnection();

                $sql = "SELECT * FROM `rezeptgesamt` Where id ='" . $id . "';";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {

                    while ($row = $result->fetch_assoc()) {
                        $recipe = new Recipe($row["id"], $row["name"], $row["beschreibung"], $row["zubereitung"], $row["url"]);
                    }
                }
            }
            else{
                return new Recipe("","","","", "");
            }

        } catch (Exception $e) {
            return $recipe;
        }
        return $recipe;
    }

    public static function getIngredensByRecipeId(String $id): array
    {
        try {
            $recipeIngedens = array();
            if($id != '') {

                $conn = self::getConnection();

                $sql = "SELECT zutat_rezept.id, einheit.einheitkuerzel ,zutat_rezept.menge, zutat.name, zutat.id as ZutatID FROM `zutat_rezept`
                        left JOIN zutat on zutat_rezept.zutatId = zutat.id
                        left join einheit on zutat.einheitId = einheit.id
                    where rezeptId = '" . $id . "';";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {

                    while ($row = $result->fetch_assoc()) {
                        array_push($recipeIngedens, new RezeptZutaten($row["name"], $row["einheitkuerzel"], $row["menge"], $row["id"]));
                    }
                }
            }
        } catch (Exception $e) {
            return $recipeIngedens;
        }
        return $recipeIngedens;
    }

    public static function getRecepiesByIngredeans(): array
    {
        //TODO: Select Befehl erstellen
        return array();
    }

    public static function CreatRecipe(Recipe $recipe, array $ingredeans)
    {
        if (self::CheckIfRecipeAllreadyExists($recipe)){
            return;
        }
        //TODO: Erstellen eines Rezeptes
    }

    public static function RrcepieDone(Int $RecepieID)
    {
        $conn = self::getConnection();
        $ingredeans = self::getIngredensByRecipeId($RecepieID);
        foreach ($ingredeans as $ingeredeant){

            $smt = $conn->prepare("UPDATE `zutatinventar` SET `menge`=(SELECT zutatinventar.menge From zutatinventar WHERE id = ?) - ? WHERE `id` = ?");

            if(!$smt){
                echo "Error Prepareing Statment ";
            }

            $var1 = $ingeredeant->getID();
            $var2 = $ingeredeant->getAmount();

            $smt->bind_param("iii", $var1, $var2, $var1);
            if(!$smt->execute()){
                echo "Error Creating record ". $smt->error;
            }
        }

    }

    private static function CheckIfZutatAllreadyExists(Ingredient $ingredient) : bool
    {
        try {
            $conn = self::getConnection();
            $sql = "SELECT * FROM `zutatgesamt` WHERE `name`  = ?";
            $stmt = $conn->prepare($sql);
            $name = $ingredient->getIngredient() ;
            $stmt->bind_param("s", $name);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                return true;
            } else {
                return false ;
            }
        } catch (Exception $e) {
            return false ;
        }
    }

    private static function CheckIFQuanteteyAllreadyExists(int $ZutatID){
        try {
            $conn = self::getConnection();
            $sql = "SELECT `id` FROM `zutatinventar` WHERE `zutatId` = ?";
            $stmt = $conn->prepare($sql);

            $stmt->bind_param("i", $ZutatID);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                return true;
            } else {
                return false ;
            }
        } catch (Exception $e) {
            return false ;
        }
    }

    private static function CheckIfRecipeAllreadyExists(Recipe $rezept) : bool
    {
        try {
            $conn = self::getConnection();
            $sql = "SELECT * FROM `rezeptgesamt` WHERE `name`  = ?";
            $stmt = $conn->prepare($sql);
            $name = $rezept->getName();
            $stmt->bind_param("s", $name);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                return true;
            } else {
                return false ;
            }
        } catch (Exception $e) {
            return false ;
        }
    }
}
