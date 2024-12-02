<div class="MainCard" style="background-image: url('<?php echo ("Views/Resources/" . $data['ResourceName']) ?>');">

<?php 
if(empty($link))
{
    $link = "#";
}

foreach($data['titles'] as $title) 
{
    echo '<h2 class="CardTitle">' . $title . '</h2>';
}

foreach($data['subtitles'] as $subtitle) 
{
    echo '<p class="CardSubTitle">'. $subtitle . '</p>';
}
?>

    <a class="CardLink" href="<?= $data['linkHRef'] ?>">
    <span class="CardLink_Text"><?= $data['linkTitle'] ?></span><span class="CardLink_Icon">></span>
    </a>

</div>
