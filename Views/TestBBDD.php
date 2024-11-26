<h1>HELLO TEST BBDD</h1>

<?php

include_once("Framework\DAO\DAO.php");
include_once("Configuration\Configuration.php");

$dao = new DAO(DEBUG_MODE);
$result = $dao->GetUserDataByMailAndPassword("admin@admin.com","12345");
echo"<br>";
var_dump($result);

?>