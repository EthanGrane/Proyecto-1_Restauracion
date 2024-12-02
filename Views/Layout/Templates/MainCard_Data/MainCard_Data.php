<?php

class MainCard_Data
{
    // Migrar a la BBDD 

    static $data =
        [
            "SpookyCola" => [
                "titles" => 
                [
                    "Spooky-Cola",
                    "solo en Halloween"
                ],
                "subtitles" => ["SIN TRUCOS. SOLO TRATOS"],
                "ResourceName" => "MainCard_Background_SpookyCola.png",
                "linkTitle" => "Ver Carta",
                "linkHRef" => "/Menu"
            ],

            "TeriyakiBowl" => [
                "titles" => ["TERIYAKI BOWL"],
                "subtitles" => ["Ofertas que dan miedo!"],
                "ResourceName" => "MainCard_Background_TeriyakyBowl.png",
                "linkTitle" => "Comprar Ahora",
                "linkHRef" => "/Menu"
            ]
        ];

    public static function GetDataByKey($key): array
    {
        return self::$data[$key];
    }
}

?>