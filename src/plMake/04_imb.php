<?php
    include($_SERVER['DOCUMENT_ROOT']."/kMag2/src/_layouts/header.php");
    
    include($_SERVER['DOCUMENT_ROOT']."/kMag2/models/Article.php");
    include($_SERVER['DOCUMENT_ROOT']."/kMag2/models/DocRig.php");
    include($_SERVER['DOCUMENT_ROOT']."/kMag2/models/MagAna.php");    
    include($_SERVER['DOCUMENT_ROOT']."/kMag2/models/PLUtils.php");
    
    $id = $_GET['id'];
    $id_pl = $_GET['id_pl'];
    $collo = getNumeric('collo');
    $prt = getNumeric('prt');
    $artCollo = getString('artcollo');
    $desCollo = getString('descollo');
    $nColli = getNumeric('ncolli');

    $pesocollo = PLUtils::getPesoNettoCollo($id_pl, $id, $collo);
    $reparto = PLUtils::getRepartoPl($id);
    $listReparti = MagAna::getReparti();
    $listPallets = Article::getPallets();
?>

<style>
    label	{float: left; width: 60px;}
    label.checkbox	{float: none; width: 100px;}
    body	{width: 250px;}
</style>

<div style="width: 250px">
    <form name="plimb" method="get" action="pl_05_wrImb.php" onsubmit="return checkImbForm();">

        <label for="art">Imballo</label>
        <input type="text" id="art" name="art" onblur="decodeImb(this);">
        <br/>

        <fieldset>
            <legend>Dimensioni</legend>
            <input style="width: 40px" type="text" size="4" name="imb_u_misural" id="imb_u_misural" 
                onblur="copiaVal(this, document.getElementById('pal_u_misural'));"> 
             X 
            <input style="width: 40px" type="text" size="4" name="imb_u_misuras" id="imb_u_misuras"
                onblur="copiaVal(this, document.getElementById('pal_u_misuras'));"> 
             X 
            <input style="width: 40px" type="text" size="4" name="imb_u_misurah" id="imb_u_misurah"
                onblur="copiaVal(this, document.getElementById('altezza'));">
             in cm
            <br/>
            (Largh. x Profondità x (H)Altezza)
        </fieldset>

        <div id="divpesocollo">
            <fieldset>
                <legend>Peso collo in kg</legend>
                <input type="text" size="6" name="pesocollo" id="pesocollo" onblur="chkPesoCollo(this);">
            </fieldset>
        </div>

        <?php if($nColli>1) { ?>
            <div id="collo2" style="background: #c0ffc0;">
                Secondo collo
                <br/>
                <label for="art">Imballo</label>
                <input type="text" id="art2" name="art2" onblur="decodeImb2(this);">
                <br/>

                <fieldset>
                    <legend>Dimensioni</legend>
                    <input style="width: 40px" type="text" size="4" name="imb_u_misural2" id="imb_u_misural2" 
                        onblur="copiaVal(this, document.getElementById('pal_u_misural'));"> 
                    X 
                    <input style="width: 40px" type="text" size="4" name="imb_u_misuras2" id="imb_u_misuras2"
                        onblur="copiaVal(this, document.getElementById('pal_u_misuras'));"> 
                    X 
                    <input style="width: 40px" type="text" size="4" name="imb_u_misurah2" id="imb_u_misurah2"
                        onblur="copiaVal(this, document.getElementById('altezza'));">
                    in cm
                    <br/>
                    (Largh. x Profondità x (H)Altezza)
                </fieldset>

                <div id="divpesocollo2">
                    <fieldset>
                        <legend>Peso Secondo collo in kg</legend>
                        <input type="text" size="6" name="pesocollo2" id="pesocollo2" onblur="chkPesoCollo(this, true);">
                    </fieldset>
                </div>
            </div>
        <?php } ?>
        
        <label for="rep">Reparto</label>
        <br/>
        <select id="rep" name="rep">
            <?php foreach($listReparti['data'] as $pallet){ ?>
                <option value="<?php print $pallet['codice'] ?>" <?php ($reparto==$pallet['codice'] ? print "selected=selected" : "") ?>><?php print $pallet['descrizion'] ?></option>
            <?php } ?>
        </select>

        <input type="checkbox" id="hasbanc" name="hasbanc" value="hasbanc" onclick="clickBancale();">
        <label for="hasbanc" class="checkbox">Bancalato</label>
        
        <div id="askbanc" style="background: #c0e0ff; display: none;">
            <label for="bancnum">Bancale</label>
            <input type="text" id="bancnum" name="bancnum" size="2" value="1">
            <input type="checkbox" id="closebanc" name="closebanc" value="close" onclick="showHideText(this, 'askcodbanc');"> 
            <label for="closebanc" class="checkbox">Chiudi bancale</label>
            
            <div id="askcodbanc" style="display: none;">
                <label for="codbanc">Tipo</label>
                <select style="width: 280px; font-size: 78%" id="codbanc" name="codbanc" onchange="decodeBanc(this);">
                    <option value="NONE"> - Scegli bancale - </option>
                    <?php foreach($listPallets['data'] as $pallet){ ?>
                        <option value="<?php print $pallet['codice'] ?>"><?php print $pallet['descrizion'] ?></option>
                    <?php } ?>
                </select>

                <fieldset>
                    <legend>Dimensioni</legend>
                    <input style="width: 40px" type="text" size="4" name="pal_u_misural" id="pal_u_misural">
                     X 
                    <input style="width: 40px" type="text" size="4" name="pal_u_misuras" id="pal_u_misuras">
                     X 
                    <input style="width: 40px" type="text" size="4" name="altezza" id="altezza">
                    in cm
                    <br/>
                    (Largh. x Profondità x (H)Altezza)
                </fieldset>

                <fieldset>
                    <legend>Peso bancale in kg</legend>
                    <input type="text" size="4" name="pesobanc" id="pesobanc">
                </fieldset>

                <input type="checkbox" id="prtbanc" name="prtbanc" value="1">
                <label for="prtbanc" class="checkbox">Stampa bancale</label>
            </div>
        </div>

        <?php
            hiddenField("id",$id);
            hiddenField("id_pl",$id_pl);
            hiddenField("collo",$collo);
            hiddenField("prt",$prt);
            hiddenField("artcollo",$artCollo);
            hiddenField("descollo",$desCollo);
            hiddenField("ncolli",$nColli);
        ?>
                        
        <br/>
        <input style="float: right" type="submit" value="Procedi">
    </form>
</div>

<?php
    setFocus("art");
    disableCR();
    goMain();
    include($_SERVER['DOCUMENT_ROOT']."/kMag2/src/_layouts/footer.php");
?>