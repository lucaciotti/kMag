<?php
    include($_SERVER['DOCUMENT_ROOT']."/kMag2/src/_layouts/header.php");

    $errMessage = trim($_GET['errMessage']);
?>
<h2>Attenzione! Errore Riscontrato</h2>

<h3><?php print $errMessage; ?></h3>

<br><br>
<a class="menu" href="01_ask.php">Altra ricerca</a>
<br>

<?php
    setFocus('id');
    goMain();
    include($_SERVER['DOCUMENT_ROOT']."/kMag2/src/_layouts/footer.php");
?>