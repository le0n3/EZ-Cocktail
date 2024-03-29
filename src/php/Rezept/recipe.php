<?php

class Recipe
{
    private string $Id;
    private string $Name;
    private string $Beschreibung;
    private string $Zubereitung;
    private string $Url;

    public function __construct(string $Id, string $Name, string $Beschreibung, string $Zubereitung, string $Url) {
        $this->Id = $Id;
        $this->Name = $Name;
        $this->Beschreibung = $Beschreibung;
        $this->Zubereitung = $Zubereitung;
        $this->Url = $Url;
    }

    public function generateRecepeCard(): string
    {
        return "<div class=\"card openDetails\" data-bs-toggle=\"modal\" data-bs-target=\"#recipeDetail\" data-id=\"". $this->Id ."\">
                <img src=\"". $this->Url ."\" class=\"card-img-top\" alt=\"cooler-gandalf\">
                <div class=\"card-body\">
                  <h5 class=\"card-title\">". $this->Name ."</h5>
                  <div class=\"description-container\">
                  ". $this->Beschreibung ."
                  </div>
                </div>
              </div>";
    }

    public function getName(): string
    {
        return $this->Name;
    }

    public  function getDescription(): string
    {
        return $this->Beschreibung;
    }

    public function  getZubereitung(): string
    {
        return $this->Zubereitung;
    }

    public function  getId(): string
    {
        return $this->Id;
    }

    public function getUrl(): string
    {
        return $this->Url;
    }
}