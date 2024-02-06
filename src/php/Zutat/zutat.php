<?php

class Ingredient
{
    private $id;
    private $ingredient;
    private $description;
    private $quantity;
    private $type;

    private $longunit;

    private $unit;

    public function __construct($id, $ingredient, $description, $quantity, $type, $unit ,$longUnit)
    {
        $this->id = $id;
        $this->ingredient = $ingredient;
        $this->description = $description;
        $this->quantity = $quantity;
        $this->type = $type;
        $this->unit = $unit;
        $this->longunit = $longUnit;
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

    public function getLongUnit()
    {
        return $this->longunit;
    }
}