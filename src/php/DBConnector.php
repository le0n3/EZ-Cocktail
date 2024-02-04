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

    public static function readFiltertngredient(String $Name = "", String $Menge = "", String $Einheit = "", String $Typ ="", String $Beschribung= "", String $OrderBy = "" , String $Reinfolge): array
    {
        try {

            $ingredienz = array();
            $conn = self::getConnection();

            $sql = "SELECT * FROM `zutatgesamt` where name LIKE '%". $Name."%' and (menge LIKE '%". $Menge."%' or menge is null)  and `einheit` LIKE '%". $Einheit."%' and typ LIKE '%". $Typ."%' and beschreibung LIKE '%". $Beschribung."%' ORDER BY ". $OrderBy." ". $Reinfolge.";";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {

                while ($row = $result->fetch_assoc()) {

                    array_push($ingredienz, new Ingredient($row["id"], $row["name"], $row["beschreibung"],array_key_exists('menge', $row)? $row["menge"]?? 0 : 0, $row["typ"], $row["einheit"]));
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
                return new Ingredient($row["id"], $row["name"], $row["beschreibung"], array_key_exists('menge', $row) ? $row["menge"] ?? 0 : 0, $row["typ"], $row["einheit"]);
            } else {
                return null;
            }
        } catch (Exception $e) {
            return null;
        }
    }

    public static function createIngredient(Ingredient $ingredeant, String $unitLong) {
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


        $var2 = $ingredeant->getUnit();

        $smt2->bind_param("sss", $unitLong, $unitLong, $var2);
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

        $smt3->bind_param("ssss", $var1, $var2, $var3, $unitLong);

        if(!$smt3->execute()){
            echo "Error Creating record ". $smt3->error;
            return;
        }

    }

    public  static function updateIngredient($ingredient)
    {
        //TODO: erstellen des Update Befehls
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

                $sql = "SELECT zutat_rezept.id, einheit.einheitkuerzel ,zutat_rezept.menge, zutat.name FROM `zutat_rezept`
                        left JOIN zutat on zutat_rezept.zutatId = zutat.id
                        left join einheit on zutat.einheitId = einheit.id
                    where rezeptId = '" . $id . "';";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {

                    while ($row = $result->fetch_assoc()) {
                        array_push($recipeIngedens, new RezeptZutaten($row["name"], $row["einheitkuerzel"], $row["menge"]));
                    }
                }
            }
        } catch (Exception $e) {
            return $recipeIngedens;
        }
        return $recipeIngedens;
    }

}
