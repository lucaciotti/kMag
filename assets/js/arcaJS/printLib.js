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