<?php
session_start();

// Destroy all session data
session_unset();
session_destroy();

// Redirect to login page (use correct path to template folder)
header("Location: ../template/login.php");
exit();
?>
