<?php
include($_SERVER['DOCUMENT_ROOT'] . "/kMag2/src/_layouts/header.php");

include($_SERVER['DOCUMENT_ROOT'] . "/kMag2/models/Article.php");
include($_SERVER['DOCUMENT_ROOT'] . "/kMag2/models/DocRig.php");
include($_SERVER['DOCUMENT_ROOT'] . "/kMag2/models/DocTes.php");
include($_SERVER['DOCUMENT_ROOT'] . "/kMag2/models/Anagrafe.php");
include($_SERVER['DOCUMENT_ROOT'] . "/kMag2/models/PLUtils.php");

$num = trim($_GET['num']);
$anno = trim($_GET['anno']);

$pbTesGet = DocTes::getByTipo($anno, 'PB', $num, "doctes.id, doctes.numerodoc, doctes.datadoc, doctes.codicecf");

if ($pbTesGet['rows'] == 0) {
    header("Location: error.php?errMessage=" . htmlentities('PackingList non Trovata'));
}
$cliGet = Anagrafe::getAnagraf($pbTesGet['data'][0]['codicecf'], 'codice,descrizion as ragsoc');
$id_testa = $pbTesGet['data'][0]['id'];

$pbBancGet = PLUtils::getListBancPB($id_testa); //prendo tutti e soli i colli

$descpl = "PB " . trim($pbTesGet['data'][0]['numerodoc']) . " " . trim($pbTesGet['data'][0]['descrizion']);

hiddenField("id_testa", $id_testa);
?>

<h3>
    Ristampa etichette Bancali:
    <br><?php echo $descpl ?>
</h3>

<input type="checkbox" onclick="toggleAll(this.checked)" id="select_all">
<label for="select_all">Sel. tutti</label>
<br>

<table>
    <?php
    for ($i = 0; $i < $pbBancGet['rows']; $i++) {
        $rep = $pbBancGet['data'][$i]['reparto'];
        $banc = $pbBancGet['data'][$i]['banc'];
        ?>
        <tr>
            <td>
                <input type="checkbox" class="linked" value="<?php echo $banc ?>" id="<?php echo $banc ?>">
                <label for="<?php echo $banc ?>"><?php echo $banc ?></label>
            </td>
            <td>
                <?php echo $rep ?>
            </td>
        </tr>
    <?php } ?>
</table>
<br>
<input type="checkbox" id="label_peso" value="1">
<label for="label_peso">Etichette peso</label>
<br><br><br>

<input type="button" value="Stampa" onclick="doPrintBanc();">

<br><br>

<a style="float: left;" class="menu" href="01reprintCollo.php">Altra ricerca</a>
<br>

<?php
disableCR();
goMain();
include($_SERVER['DOCUMENT_ROOT'] . "/kMag2/src/_layouts/footer.php");
?>