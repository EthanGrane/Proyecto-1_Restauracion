<?php

include_once("Views\Layout\Templates\MainCard_Data\MainCard_Data.php");

/*
 * Card Spooky Cola
 */

 $data = MainCard_Data::GetDataByKey(key: "SpookyCola");
 $link = "/Menu";
include("Views\Layout\Templates\Template_MainCard.php");

/*
 * Card Teriyaki
 */
$data = MainCard_Data::GetDataByKey("TeriyakiBowl");
include("Views\Layout\Templates\Template_MainCard.php");

/*
 * Half Cards
 */

include("Views\Layout\Templates\Template_HalfCard.php");

?>