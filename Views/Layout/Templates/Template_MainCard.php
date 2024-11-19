<div class="MainCard" style="background-image: url('<?php echo ("Views/Resources/" . $data['ResourceName']) ?>');">

<?php 
foreach($data['titles'] as $title) 
{
    echo '<h2 class="CardTitle">' . $title . '</h2>';
}

foreach($data['subtitles'] as $subtitle) 
{
    echo '<p class="CardSubTitle">'. $subtitle . '</p>';
}
?>
    

    <a class="CardLink" href="#">
    <span class="CardLink_Text">Ver carta</span><span class="CardLink_Icon">></span>
    </a>


</div>
