<?php
include($_SERVER['DOCUMENT_ROOT'] . "/kMag2/src/_layouts/header.php");
?>

<label for="id">ID Articolo:</label>
<input type="text" name="id" id="id" onblur="decodePrint(this);">
<hr>

<form name="input" action="02reprintCollo.php" method="get">
	<label for="num">PL numero:</label>
	<input type="text" name="num" id="num" size="4"><br>
	<label for="anno">Anno:</label>
	<input type="text" name="anno" id="anno" size="4">
	<hr>
	<input type="submit" id="btnok" value="Cerca">
</form>

<script type="text/javascript">
	//<![CDATA[
	document.getElementById('anno').value = (new Date()).getFullYear();
	//]]>
</script>

<?php
setFocus('id');
goMain();
include($_SERVER['DOCUMENT_ROOT'] . "/kMag2/src/_layouts/footer.php");
?>