<?php
include($_SERVER['DOCUMENT_ROOT'] . "/kMag2/src/_layouts/header.php");

include($_SERVER['DOCUMENT_ROOT'] . "/kMag2/models/Article.php");
$codeArt = strtoupper($_GET['articolo']);
$errMessage = "";

$anno = current_year();
$artget = Article::getArticle($codeArt, 'codice,descrizion,ubicazione');
$artUbiGet = Article::getAllUbic($codeArt);
$giacget = Article::getGiacArt($codeArt, $anno, true);
// var_dump($artUbiGet);
//print($artget['data'][0]['descrizion']);
?>
<h2><?php echo $codeArt ?></h2>
<h3><?php echo $artget['data'][0]['descrizion'] ?></h3>

<h3>Giacenze</h3>
<table>
    <col width='80'>
    <col width='200'>
    <col width='80'>
    <col width='80'>
    <tr>
        <th>Cod.Mag.</th>
        <th>Mag.</th>
        <th>Giac.</th>
        <th>Disp.</th>
    </tr>

    <?php foreach ($giacget['data'] as $giac) { ?>
        <tr>
            <td><?php echo $giac['magazzino'] ?></td>
            <td><?php echo $giac['magdesc'] ?></td>
            <td align='right'><?php echo $giac['esistenza'] ?> <?php echo $giac['unmisura'] ?></td>
            <td align='right'><?php echo $giac['esistenza'] + $giac['ordinato'] - $giac['impegnato'] ?> <?php echo $giac['unmisura'] ?></td>
            <!-- <td></td> -->
        </tr>
    <?php } ?>
</table>

<h3>Ubicazioni</h3>
<table>
    <col width='80'>
    <col width='200'>
    <tr>
        <th colspan='2'>Default: <?php echo empty($artget['data'][0]['ubicaz']) ? 'NONE' : $artget['data'][0]['ubicaz'] ?></th>
    </tr>
    <tr>
        <th colspan='2'>Altre Ubicazioni</th>
    </tr>
    <?php foreach ($artUbiGet['data'] as $ubi) { ?>
        <tr>
            <td><?php echo $ubi['ubicazione'] ?></td>
            <td><?php echo $ubi['descrubi'] ?></td>
        </tr>
    <?php } ?>
</table>

<br />
<a href="./01ask.php">Altra ricerca</a>

<?php
goMain();
include($_SERVER['DOCUMENT_ROOT'] . "/kMag2/src/_layouts/footer.php");
?>