<?php
include($_SERVER['DOCUMENT_ROOT'] . "/kMag2/src/_layouts/header.php");
?>

<label for="id">Articolo:</label>
<input type="text" id="id" onblur="decode(this, 'articolo');" />

<form name="input" action="02response.php" method="get">
    <input type="hidden" name="articolo" id="articolo" />
    <input type="submit" id="btnok" value="Cerca" onclick="decode(id);" />
</form>

<?php
goMain();
include($_SERVER['DOCUMENT_ROOT'] . "/kMag2/src/_layouts/footer.php");
?>