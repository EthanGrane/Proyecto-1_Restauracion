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
            ],

            "ComboRamen" => [
                "titles" => ["Mega Combo Ramen"],
                "subtitles" => ["Oferta por tiempo limitado usando el codigo:", "MegaCombo"],
                "ResourceName" => "MainCard_Background_ComboRamen.webp",
                "linkTitle" => "Comprar Ahora",
                "linkHRef" => "/Menu"
            ],

            "PadThai" => [
                "titles" => ["Nuevo Pad Thai"],
                "subtitles" => ["Disfruta del mejor Pad Thai al estilo Tailandes."],
                "ResourceName" => "MainCard_Background_PadThai.webp",
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