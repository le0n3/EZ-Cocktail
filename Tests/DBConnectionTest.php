<?php


use PHPUnit\Framework\TestCase;
include_once("../../EZ-Cocktail/src/php/DBConnector.php");

class DBConnectionTest extends TestCase
{

    public function testGetConnectionReturnsMysqliInstance(): void
    {
        $this->assertInstanceOf(mysqli::class, DBConnection::getConnection());
    }

    public function testGetConnectionReturnsSameInstance(): void
    {
        $connection1 = DBConnection::getConnection();
        $connection2 = DBConnection::getConnection();
        $this->assertSame($connection1, $connection2);
    }

    public function testReadWithNonEmptyResult() {

         $intgedeans = DBConnection::readFiltertIngredient(true);
         $this->assertNotEmpty($intgedeans);

    }

    public function testReadWithEmptyResult() {
        $intgedeans = DBConnection::readFiltertIngredient(true,"Unit Test");
        $this->assertEmpty($intgedeans);
    }

    public function testReadQuantetyWithNonEmptyResult() {

        $intgedeans = DBConnection::readIngredientWhithNoQuantety();
        $this->assertNotEmpty($intgedeans);

    }

    public function testgetIngredientById()
    {
        $ingredient = DBConnection::getIngredientById("1");
        $this->assertInstanceOf(Ingredient::class, $ingredient);
    }

    public function testgetIngredientByIdWhitNull()
    {
        $ingredient = DBConnection::getIngredientById("123");
        $this->assertNull($ingredient);
    }

    public function testreadAllRecipes()
    {
        $Recipes = DBConnection::readAllRecipes();
        $this->assertIsArray($Recipes);
        $this->assertNotEmpty($Recipes);
    }

    public function testgetRecipeById()
    {
        $recipe = DBConnection::getRecipeById("1");
        $this->assertInstanceOf(Recipe::class, $recipe);
        $this->assertSame("Jacky Cola", $recipe->getName());
    }

    public function testgetRecipeByIdNull()
    {
        $recipe = DBConnection::getIngredientById("Unit Test");
        $this->assertNull($recipe);
    }


    public function testgetIngredientsByRecipeId()
    {
        $ingredients = DBConnection::getIngredientsByRecipeId("1");
        $this->assertIsArray( $ingredients);
        $this->assertCount(3, $ingredients);
    }

    public function testgetIngredientsByRecipeIdWithNULL()
    {
        $ingredients = DBConnection::getIngredientsByRecipeId("Unit Test");
        $this->assertCount(0, $ingredients);

    }

    public function testgetRecipesByIngredients()
    {
        $recipes = DBConnection::S})})();
        $this->assertIsArray( $recipes);
        $this->assertCount(1, $recipes);
    }
}
