<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Onest:wght@100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

<!-- Bootstrap Lib -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<!-- Styles -->
<link rel="stylesheet" href=".\Views\Styles\MainStyles.css">
<link rel="stylesheet" href=".\Views\Styles\HeaderStyles.css">
<link rel="stylesheet" href=".\Views\Styles\FooterStyles.css">
<link rel="stylesheet" href=".\Views\Styles\MainCard.css">
<link rel="stylesheet" href=".\Views\Styles\HalfCard.css">
<link rel="stylesheet" href=".\Views\Styles\CartStyles.css">

<?php
if (empty($title)) 
{
    $title = "";
}
else
{
    $title = " - " . $title;
}
?>

<title> Cripsy-19 <?= $title ?> </title>