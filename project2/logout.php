<!--MAGGIE XIN YI LAW 103488683-->

<?php
session_start();
session_unset();
session_destroy();
header("Location: manage.php");
exit();
?>