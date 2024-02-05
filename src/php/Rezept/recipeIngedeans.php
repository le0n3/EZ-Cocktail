<?php
class RezeptZutaten
{
    private string $zutat;
    private string $einheit;
    private int $amount;
    private Int $ID;

    public function __construct(string $zutat, string $einheit, int $amount, int $ID)
    {
        $this->zutat = $zutat;
        $this->einheit = $einheit;
        $this->amount = $amount;
        $this->ID = $ID;
    }

    public function GenerateBulletpoint():String
    {
        return "<li>".$this->amount." ". $this->einheit." ".$this->zutat."</li>";
    }
    /* Zurückgeben von Zutat */
    public function getZutat(): string
    {
        return $this->zutat;
    }

    /* Zurückgeben von Einheit */
    public function getEinheit(): string
    {
        return $this->einheit;
    }

    /* Zurückgeben von Amount */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /* Zurückgeben von IngeredeantID */
    public function getID(): int
    {
        return $this->ID;
    }
}
