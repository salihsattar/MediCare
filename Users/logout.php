<?php
session_start();        // Start session (required before destroying)
session_unset();        // Unset all session variables
session_destroy();      // Destroy the session

// Redirect to index page
header("Location: index.php");
exit();
