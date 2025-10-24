<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// si no hay user_id, manda al index (este guardia solo se encuentra en las paginas privadas)
if (empty($_SESSION['user_id'])) {
    header('Location: /Proyecto-1/index.php');
}