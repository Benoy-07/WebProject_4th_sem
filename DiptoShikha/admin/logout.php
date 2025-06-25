<?php
session_start();          // সেশন শুরু করো
session_unset();          // সব session ভ্যারিয়েবল খালি করো
session_destroy();        // session পুরোপুরি ধ্বংস করো

// হোম পেজে পাঠিয়ে দাও
header("Location: /DiptoShikha/index.php");
exit();
?>
