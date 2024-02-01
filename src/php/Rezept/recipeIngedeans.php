<?php
class RezeptZutaten
{
    private string $zutat;
    private string $einheit;
    private int $amount;

    public function __construct(string $zutat, string $einheit, int $amount)
    {
        $this->zutat = $zutat;
        $this->einheit = $einheit;
        $this->amount = $amount;
    }

    public function GenerateBulletpoint():String
    {
        return "<li>".$this->amount." ". $this->einheit." ".$this->zutat."</li>";
    }
}
