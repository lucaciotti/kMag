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
        var umBox = document.getElementById('um');
        var qtaBox = $('#qta');
        //imposto Fattore di conversione precedente
        var oldFatt = umBox.options[umBox.selectedIndex].value;
        $('#oldFatt').val(oldFatt);

        for (var j = 0; j < umBox.length; j++) {
            if (umBox.options[j].innerHTML == newUm) {
                umBox.selectedIndex = j;
                qtaBox.val(qtaBox.val() * oldFatt / umBox.options[j].value);
                $("#newFatt").val(umBox.options[j].value);
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

function checkLotto (obj) {
    var lotto = cleanCode(obj.value.trim().toUpperCase());
    obj.value = lotto;
    if(lotto=='') return true;
    detailLotto = $.parseJSON(getLottiArti(codArt, lotto));
    if(detailLotto == '*error*') {
        alert('Lotto ' + lotto + ' Not available');
        obj.value = '';
        obj.focus();
        return false;
    }
    // console.log(detailLotto[0].u_noce);
    if (soloceCli && detailLotto[0].u_noce) {
        alert("Lotto " + lotto + " non di origine CEE. Non utilizzabile per questo cliente.");
        obj.value = "";
        obj.focus();
        return false;
    } else {
        var isIndustria = $.parseJSON(getSetInd(settoreCli))!='*error*' ? true : false;
        if (isIndustria && detailLotto[0].u_noindus) {
            alert("Lotto " + lotto + " non per industria. Non utilizzabile per questo cliente.");
            obj.value = "";
            obj.focus();
            return false;
        } else{
            document.getElementById('qta').focus();
            return true;
        }
    }
};

function checkQta (obj) {
    var qta = obj.value;
    var qtaRes = $('#qtaRes').val();
    var oldFatt = $('#fattDoc').val();
    var umBox = document.getElementById('um');
    var newFatt = umBox.options[umBox.selectedIndex].value;
    $('#newFatt').val(newFatt);
    qtaRes = qtaRes * oldFatt / newFatt;
    var lotto = $("#lotto").val().trim();
    if ($('#lottoobb').text().trim() == 'Obbligatorio' && lotto==''){
        alert('Lotto OBBLIGATORIO');
         $("#lotto").val('');
         $("#lotto").focus();
        return false;
    }
    if (qta != 0) {
        var giac = checkGiacArtix(codArt, lotto, esercizio);
        var fatt = newFatt;
        var um = umBox.options[umBox.selectedIndex].innerHTML;
        giac = giac / fatt;
        if (qta > qtaRes) {
            alert("Qta Superiore a Qta Residua");
            return false;
        } else {
            if (qta > giac) {
                if (lotto != "") {
                    var message = "Qta Superiore a GIACENZA LOTTO : " + giac + " " + um;
                } else {
                    var message = "Qta Superiore a GIACENZA: " + giac + " " + um;
                }
                alert(message);
                obj.focus();
                return false;
            } else {
                return true;
            }
        }
    }
};


function checkCollo(obj) {
    var idpl = $('#idtesta').val();
    soloNumeri("collo");
    var collo = obj.value;
    var close = $('#close').is(':checked');
    var nColli = $('#ncolli').val();

    if (collo == 0) {
        return true;
    }

    var url = window.basePATH + "plColloGet.php?id=" + idpl + "&termid=" + termid;
    var milliseconds = new Date().getTime();
    url += "&x=" + milliseconds;
    //alert(url);
    makeHttpXml();
    httpXml.open("GET", url, false);
    httpXml.send(null);
    var cRet = httpXml.responseText;
    if (cRet != collo){
        alert("Numero collo utilizzato da altro operatore\n" +
            "Primo numero disponibile: " + cRet);
        obj.value = cRet;
    }

    //prenoto il collo

    //chiudo il collo
    
    //cTest = cRet;
    if (cRet.slice(0, 2) !== "ok") {
        if (cRet.slice(0, 2).trim() === "0") {
            alert("Collo chiuso!");
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
