<?php

include_once("Zutat/zutat.php");
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

    public static function readFiltertngredient(String $Name = "", String $Menge = "", String $Einheit = "", String $Typ ="", String $Beschribung= ""): array
    {
        try {

            $ingredienz = array();
            $conn = self::getConnection();

            $sql = "SELECT * FROM `zutatgesamt` where Zutat LIKE '%". $Name."%' and menge LIKE '%". $Menge."%' and `einheitBezeichnung` LIKE '%". $Einheit."%' and Typen LIKE '%". $Typ."%' and beschreibung LIKE '%". $Beschribung."%';";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {

                while ($row = $result->fetch_assoc()) {
                    array_push($ingredienz, new Ingredient($row["id"], $row["Zutat"], $row["beschreibung"], $row["menge"], $row["Typen"], $row["einheitBezeichnung"]));
                }
            }

        } catch (Exception $e) {
            return $ingredienz;
        }
        return $ingredienz;
//$conn->close();
    }

    public static function createIngredient($ingredeant) {

       //TODO: erstellen des Create Befehles
    }

    public  static function updateIngredient($ingredient)
    {
        //TODO: erstellen des Update Befehls
    }
    public static function getAllRecipe()
    {

    }

}
