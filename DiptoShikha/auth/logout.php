<?php
session_start();
session_destroy();
header("Location: /DiptoShikha/index.php");
exit();
?>