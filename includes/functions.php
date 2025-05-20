<?php
function logout() {
    session_destroy();
    header("Location: ../SignIn.php");
    exit;
}

if (isset($_POST['logout'])) {
    logout();
}
