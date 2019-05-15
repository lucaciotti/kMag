function printCollo(id, collo) {
    "use strict";
    var url = "pl-print.php?id=" + id + "&collo=" + collo;
    var milliseconds = new Date().getTime();
    url += "&x=" + milliseconds;
    makeHttpXml();
    httpXml.open("GET", url, false);
    httpXml.send(null);
    var cRet = httpXml.responseText;
    return true;
}

function createCookie(name, value, days) {
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        var expires = "; expires=" + date.toGMTString();
    }
    else var expires = "";
    document.cookie = name + "=" + value + expires + "; path=/";
}

function setPrinter(value) {
    createCookie("plprinter", value, 10);
    return true;
}