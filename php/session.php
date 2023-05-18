<?php
if (!empty($_GET['session'])) {
    session_name($_GET['session']);
}
session_start();

if(empty($_SESSION['nickname'])) {
    echo json_encode(['session' => false]);
    die();
}

echo json_encode([
    'session' => true,
    'nickname' => $_SESSION['nickname'],
    'date_of_birth' => $_SESSION['date_of_birth'],
    'avatar_url' => $_SESSION['avatar_url'],
]);
