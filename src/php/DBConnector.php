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

    public static function readAll()
    {
        try {

            $ingredienz = array();
            $conn = self::getConnection();

            $sql = "SELECT zutat.id, typ.name as Typen, zutat.name as Zutat, zutat.beschreibung,zutatinventar.menge, einheit.einheitBezeichnung FROM `zutat` Left JOIN einheit on zutat.id = einheit.zutatId Left JOIN typ on zutat.id = typ.zutatId left Join zutatinventar on zutat.id = zutatinventar.zutatId; ";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {

                while ($row = $result->fetch_assoc()) {
                    array_push($ingredienz, new Ingredient($row["id"], $row["Zutat"], $row["beschreibung"], $row["menge"], $row["Typen"], $row["einheitBezeichnung"]));
                }
            }

        }catch (Exception $e){
            return $ingredienz;
        }
        return $ingredienz;
//$conn->close();
    }
}