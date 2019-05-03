function stopRKey(evt) {
    var evt = (evt) ? evt : ((event) ? event : null);
    var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
    if ((evt.keyCode == 13) && (node.type == "text")) {
        return false;
    }
}

 function soloNumeri(id) {
    var valore = document.getElementById(id).value
    valore = valore.replace(/[^\d]/g, '')
    document.getElementById(id).value = valore
}


// ---------------------------------------------

var changeIframeSrc = function (id, url) {
    "use strict";
    var el = document.getElementById(id);
    if (el && el.src) {
        el.src = url;
        return false;
    }
    return true;
};

var del = function (table, id) {
    "use strict";
    var url = "delete.php?id=" + id + "&table=" + table;
    sendUrl(url);
    window.location.reload();
};

var showHideText = function (box, id) {
    var elm = document.getElementById(id);
    elm.style.display = box.checked ? "block" : "none";
};