<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="it">

<head>
    <title>k-Mag</title>
    <link rel="shortcut icon" href="assets/images/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="assets/css/style.css" type="text/css">
</head>

<body>
    <center>
        <a href="src/menus/main.php"><img src="assets/images/ditte/italia.jpg" height="50" /></a>&nbsp;
        <h2>Selezionare nazione</h2>
    </center>
    <div class="footmsg">
        <center>
            <hr size="1">
            &copy; 2010- <?php print(current_year()); ?> Krona Koblenz Spa
            <br />
        </center>
    </div>

</body>

</html>

<?php
// Calcolo dell'anno corrente
function current_year()
{
    // $lt = localtime(time(), true);
    // return ($lt[tm_year]+1900);
    return date("Y");
}
?>