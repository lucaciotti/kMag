<?php
include($_SERVER['DOCUMENT_ROOT'] . "/kMag2/src/_layouts/header.php");

include($_SERVER['DOCUMENT_ROOT'] . "/kMag2/models/Article.php");
include($_SERVER['DOCUMENT_ROOT'] . "/kMag2/models/DocRig.php");
include($_SERVER['DOCUMENT_ROOT'] . "/kMag2/models/DocTes.php");
include($_SERVER['DOCUMENT_ROOT'] . "/kMag2/models/Anagrafe.php");
include($_SERVER['DOCUMENT_ROOT'] . "/kMag2/models/PLUtils.php");

$num = trim($_GET['num']);
$anno = trim($_GET['anno']);

$prtlist = CONFIG::$PRINTERS;

$pbTesGet = DocTes::getByTipo($anno, 'PB', $num, "doctes.id, doctes.numerodoc, doctes.datadoc, doctes.codicecf");

if ($pbTesGet['rows'] == 0) {
    header("Location: error.php?errMessage=" . htmlentities('PackingList non Trovata'));
}
$cliGet = Anagrafe::getAnagraf($pbTesGet['data'][0]['codicecf'], 'codice,descrizion as ragsoc');
$id_testa = $pbTesGet['data'][0]['id'];

$pbColliGet = PLUtils::getListColliPB($id_testa); //prendo tutti e soli i colli

$descpl = "PB " . trim($pbTesGet['data'][0]['numerodoc']) . " " . trim($pbTesGet['data'][0]['descrizion']);

hiddenField("id_testa", $id_testa);
?>

<h3>
    Ristampa etichette Colli:
    <br><?php echo $descpl ?>
</h3>

<input type="checkbox" onclick="toggleAll(this.checked)" id="select_all">
<label for="select_all">Sel. tutti</label>
<br>

<table>
    <?php
    for ($i = 0; $i < $pbColliGet['rows']; $i++) {
        $rep = $pbColliGet['data'][$i]['reparto'];
        $collo = $pbColliGet['data'][$i]['collo'];
        ?>
        <tr>
            <td>
                <input type="checkbox" class="linked" value="<?php echo $collo ?>" id="<?php echo $collo ?>">
                <label for="<?php echo $collo ?>"><?php echo $collo ?></label>
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

<label for="prt">Stampante</label>
<select id="prt" name="prt" onchange="setPrinter(this.value);">
    <?php for ($i = 0; $i < count($prtlist); $i++) { ?>
        <option value="<?php print $prtlist[$i] ?>" <?php ($default_prt == $prtlist[$i] ? print "selected=selected" : "") ?>>
            <?php print $prtlist[$i] ?>
        </option>
    <?php } ?>
</select>
<br><br>

<input type="button" value="Stampa" onclick="doPrint();">

<br><br>

<a style="float: left;" class="menu" href="01reprintCollo.php">Altra ricerca</a>
<br>

<?php
disableCR();
goMain();
include($_SERVER['DOCUMENT_ROOT'] . "/kMag2/src/_layouts/footer.php");
?>