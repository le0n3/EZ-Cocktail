<?php

class Ingredient
{
    private $id;
    private $ingredient;
    private $description;
    private $quantity;
    private $type;

    private $unit;

    public function __construct($id, $ingredient, $description, $quantity, $type, $unit)
    {
        $this->id = $id;
        $this->ingredient = $ingredient;
        $this->description = $description;
        $this->quantity = $quantity;
        $this->type = $type;
        $this->unit = $unit;
    }

    // getters
    public function getId()
    {
        return $this->id;
    }

    public function getIngredient()
    {
        return $this->ingredient;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getUnit()
    {
        return $this->unit;
    }

    public function generateIngredientLine()
    {
        return "<tr>
                        <td class=\"table-icon\" title=\"Eintrag bearbeiten\"><span class=\"icon icon-edit editIngredient\" data-bs-toggle=\"modal\" data-bs-target=\"#ingredientModal\" data-id='". $this->id ."'></span></td>
                        <td class=\"table-name\" title=\"". $this->ingredient ."\"><span>". $this->ingredient ."</span></td>
                        <td class=\"table-unit\" title=\"". $this->unit ."\"><span>". $this->unit ."</span></td>
                        <td class=\"table-type\" title=\"". $this->type ."\"><span>". $this->type ."</span></td>
                        <td class=\"table-description\" title=\"". $this->description ."\"><span>". $this->description ."</span></td>
                    </tr>";
    }

}