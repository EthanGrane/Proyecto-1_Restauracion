<?php

class MainCard_Data
{
    // Migrar a la BBDD 

    static $data =
        [
            "SpookyCola" => [
                "titles" => [
                    "Spooky-Cola",
                    "solo en Halloween"
                ],
                "subtitles" => ["SIN TRUCOS. SOLO TRATOS"],
                "ResourceName" => "MainCard_Background_SpookyCola.png"
            ],

            "TeriyakiBowl" => [
                "titles" => ["TERIYAKI BOWL"],
                "subtitles" => ["Ofertas que dan miedo!"],
                "ResourceName" => "MainCard_Background_TeriyakyBowl.png"
            ]
        ];

    public static function GetDataByKey($key): array
    {
        return self::$data[$key];
    }
}

?>