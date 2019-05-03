<?php
    include($_SERVER['DOCUMENT_ROOT']."/kMag2/src/_layouts/header.php");

    include($_SERVER['DOCUMENT_ROOT']."/kMag2/models/Article.php");
    $codeArt = strtoupper($_GET['articolo']);
    $errMessage = "";

    $anno = current_year();
    $artget = Article::getArticle($codeArt);
    $giacget = Article::getGiacArt($codeArt, $anno, true);
    //var_dump($giacget);
    //print($artget['data'][0]['descrizion']);
?>
<h2><?php echo $codeArt ?></h2>
<h3><?php echo $artget['data'][0]['descrizion'] ?></h3>

<h3>Giacenze</h3>
<table border='1'>
    <tr>
        <th>Mag.</th>
        <th>Giac.</th>
        <th>Disp.</th>
    </tr>

    <?php foreach ($giacget['data'] as $giac) { ?>
    	<tr>
            <td><?php echo $giac['magazzino'].' - '.$giac['magdesc'] ?></td>
            <td align='right'><?php echo $giac['esistenza'] ?><?php echo $giac['unmisura'] ?></td>
            <td></td>
	    </tr>
    <?php } ?>
</table>

<h3>Ubicazioni</h3>
<table border='1'>
    <tr>
        <td></td>
    </tr>
</table>

<br/>
<a href="./01ask.php">Altra ricerca</a>
 
<?php
    include($_SERVER['DOCUMENT_ROOT']."/kMag2/src/_layouts/footer.php");
?>