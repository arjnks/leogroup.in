<?php
require_once("../config.php");
$ghit=$con->prepare("SELECT * FROM tb_logo WHERE id=$_GET[id]");
$ghit->execute();
$rows=$ghit->fetch(PDO::FETCH_ASSOC);
unlink($rows["path"]);
$dellog=$con->prepare("DELETE FROM tb_logo WHERE id='$_GET[id]'");
$dellog->execute();
?>
<script type="text/javascript">
	window.location="add-logo.php";
</script>