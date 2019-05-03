
function decodeArt(obj) {
    var val = obj.value;
    var codArtBox = htmlEntities(String($('#codArt').text())).trim();
    if (val != "") {
        var oArt = checkCodiceArtix(val);
        var codArtRes = String(oArt.codice).trim();
        if (codArtBox !== codArtRes && codArtBox.length !== codArtRes.length) {
            obj.focus();
            alert("Codice non corrisponde");
            return false;
        }
        obj.value = codArtRes;
        obj.disabled = true;
        var newUm = oArt.xml.getElementsByTagName("unmisura")[0].firstChild.nodeValue;
        //Mappo i Box di riferimento
        var umBox = $('um');
        var qtaBox = $('qta');
        //imposto Fattore di conversione precedente
        var oldFatt = umBox.children("option:selected").val();
        $('oldFatt').val(oldFatt);

        umBox.attr('options').each( function(){
            if($(this).text()==newUM) {
                
            }
        });
        
        for (var j = 0; j < umBox.length; j++) {
            if (umBox.options[j].innerHTML == newUm) {
                umBox.selectedIndex = j;
                qtaBox.value = qtaBox.value * oldFatt / umBox.options[j].value;
                document.getElementById("newFatt").value = umBox.options[j].value;
                umBox.disabled = true;
            }
        }
        //Controllo il lotto obbligatorio
        if (oArt.xml.getElementsByTagName("lottoob")[0].firstChild.nodeValue == 0) {
            document.getElementById('lotto').disabled = false;
            document.getElementById('qta').focus();
        } else {
            document.getElementById('lotto').focus();
        }
        return true;
    }
}

function checkLotto (cCodice, obj) {
    var lotto = cleanCode(obj.value.trim());
    detailLotto = $.parseJSON(getLottiArti(codArt, lotto));
    console.log(listaLotti);

    /* if (lotto=='') {
        return true;
    }
    var lista = checkCodiceArtix(cCodice).xml.getElementsByTagName("lotto");
    for (var j = 0; j < lista.length; j++) {
        if (lista[j].firstChild.nodeValue == lotto) {
            obj.value = lotto;
            document.getElementById('qta').focus();
            return true;
        }
    }
    alert("Lotto: " + lotto + " non valido per questo articolo.");
    obj.value = "";
    obj.focus();
    return false; */
};

function checkCollo(id, collo, close, ncolli) {
    "use strict";

    //    alert("ID:" + id + " COLLO:" + collo + " CLOSE:" + close + " NCOLLI:" + ncolli);
    soloNumeri("collo");
    if (collo == 0) {
        alert("Numero collo non specificato!");
        return false;
    }
    var url = "getcollofree.php?id=" + id + "&collo=" + collo;
    if (close === true) {
        url += "&close";
    }
    if (ncolli == 2) {
        url += "&extracollo";
    }
    var milliseconds = new Date().getTime();
    url += "&x=" + milliseconds;
    //alert(url);
    makeHttpXml();
    httpXml.open("GET", url, false);
    httpXml.send(null);
    var cRet = httpXml.responseText;
    //	alert(cRet);
    if (document.getElementById("collo").readOnly) {
        return true;
    };
    //cTest = cRet;
    if (cRet.slice(0, 2) !== "ok") {
        if (cRet.slice(0, 2).trim() === "0") {
            alert("Collo gi� chiuso!");
            return true;
        } else {
            alert("Numero collo utilizzato da altro operatore\n" +
                "Primo numero disponibile: " + cRet.slice(0, 3).trim());
            document.getElementById("collo").value = cRet.slice(0, 3).trim();
            return false;
        }
    } else {
        return true;
    }
}


// ----------------

var checkLotto2 = function (obj) {
    var lotto = cleanCode(obj.value.trim());
    if ("" == lotto) {
        return true;
    }
    var soloce = $("#u_soloce").val();
    var isIndustria = $("#is_industria").val();
    if (lotto in listaLotti) {
        if (soloce != "" && listaLotti[lotto]["u_noce"] != false) {
            alert("Lotto " + lotto + " non di origine CEE. Non utilizzabile per questo cliente.");
            obj.value = "";
            obj.focus();
            return false;
        } else if (isIndustria != "" && listaLotti[lotto]["u_noindus"] != false) {
            alert("Lotto " + lotto + " non per industria. Non utilizzabile per questo cliente.");
            obj.value = "";
            obj.focus();
            return false;
        } else {
            obj.value = lotto;
            document.getElementById('qta').focus();
            return true;
        }
    }
    alert("Lotto: " + lotto + " non valido per questo articolo.");
    obj.value = "";
    obj.focus();
    return false;
};