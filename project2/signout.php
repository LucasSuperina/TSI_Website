<!--Jay Kshirsagar 105912265-->

<?php
session_start();
session_unset();
session_destroy();
header("Location: index.php");
exit();
?>