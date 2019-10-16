<?php
$pwderror = "";
$pwderrornumber = $_GET["error"];

include($_SERVER['DOCUMENT_ROOT'] . "/kMag2/src/_layouts/header.php");


if ($_GET['logOut'] == 'yes') {
    session_start();
    session_unset($_SESSION['UserPL']);
    session_destroy();
    Header("Location: index.php?error=3");
}

if (!empty($pwderrornumber)) {
    if ($pwderrornumber == 1) {
        $pwderror = "UTENTE NON ABILITATO";
    }
    if ($pwderrornumber == 2) {
        $pwderror = "PASSWORD ERRATA";
    }
    if ($pwderrornumber == 3) {
        $pwderror = "LOGUT EFFETTUATO";
    }
}
?>
<h3 class='title'>Login</h3>

<div style="text-align: center;">
    <div style="width: 320px; display: block; margin-left: auto; margin-right: auto;">
        <form action='enter.php' method='POST'>
            <label for="codice" style="background-color: #CCFFFF; float: left; text-align: right; width: 150px;">User:</label>
            <input name="codice" id="codice" type="text" size="15">
            <br>
            <label for="password" style="background-color: #CCFFFF; float: left; text-align: right; width: 150px;">Password:</label>
            <input name="password" id="password" type="password" size="15">

            <?php if (!empty($pwderror)) { ?>
                <br>
                <p style="background-color: #ff6633; display: block; text-align: center;"><b> <?php echo $pwderror ?> </b></p>
            <?php } ?>
            <br>
            <input type="submit" value="Entra">
        </form>
    </div>
</div>

<?php
logOut();
goMain();
footer();
?>