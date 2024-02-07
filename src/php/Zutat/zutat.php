<?php

class Ingredient
{
    private string $id;
    private string $name;
    private string $description;
    private string $quantity;
    private string $type;
    private string $longUnit;
    private string $unit;

    public function __construct($id, $name, $description, $quantity, $type, $unit ,$longUnit)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->quantity = $quantity;
        $this->type = $type;
        $this->unit = $unit;
        $this->longUnit = $longUnit;
    }

    // Getters
    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getQuantity(): string
    {
        return $this->quantity;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getUnit(): string
    {
        return $this->unit;
    }

    public function getLongUnit(): string
    {
        return $this->longUnit;
    }
}