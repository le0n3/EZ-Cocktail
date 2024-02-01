<?php

class Recipe
{
    private string $Id;
    private string $Name;
    private string $Beschreibung;
    private string $Url;

    public function __construct(string $Id, string $Name, string $Beschreibung, string $Url) {
        $this->Id = $Id;
        $this->Name = $Name;
        $this->Beschreibung = $Beschreibung;
        $this->Url = $Url;
    }

    public function generateRecepeCard()
    {
        return "<div class=\"cards-container m-auto shadow rounded bg-light\">
            <div class=\"card openDetails\" data-bs-toggle=\"modal\" data-bs-target=\"#recipeDetail\" data-id=\"". $this->Id ."\">
                <img src=\"". $this->Url ."\" class=\"card-img-top\" alt=\"cooler-gandalf\">
                <div class=\"card-body\">
                  <h5 class=\"card-title\">". $this->Name ."</h5>
                  <div class=\"description-container\">
                  ". $this->Beschreibung ."
                  </div>
                </div>
              </div>
            </div>";
    }

    public function getName()
    {
        return $this->Name;
    }
    
}