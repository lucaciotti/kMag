<?php
    include($_SERVER['DOCUMENT_ROOT']."/kMag2/src/_layouts/header.php");
?>

<form name="input" action="02_resp.php" method="get">
    <label for="id">ID Articolo:</label>
    <input type="text" name="id" id="id" onchange="cleanCode(this.value, 'id');">
    <input type="submit" id="btnok" value="Cerca">
</form>



<?php
    setFocus('id');
    goMain();
    include($_SERVER['DOCUMENT_ROOT']."/kMag2/src/_layouts/footer.php");
?>