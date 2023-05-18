<?php
if(!empty($_POST['session'])) {
    session_name($_POST['session']);
}
session_start();

if (empty($_POST['nickname'])) {
    send_error('Nickname not entered!');
}

if (empty($_POST['password'])) {
    send_error('Password not entered!');
}

$nickname = $_POST['nickname'];
$password = $_POST['password'];

include 'hash.php';
include 'db.php';

if (login_attempt_number() > 10) {

    send_error('Too many login attempts! Try again in 5 minutes.');
}

$sql = "SELECT * FROM users WHERE nickname = '$nickname'";
$result = mysqli_query($db_connect, $sql);

if(!mysqli_num_rows($result)) {

    write_bad_login_attempt();
    send_error('Incorrect nickname or password!');
}

$row = mysqli_fetch_assoc($result);

if(sha256(sha256($password).$row['salt']) != $row['pw_salt_hash']) {

    write_bad_login_attempt();
    send_error('Incorrect nickname or password!');
}

flush_bad_login_attempts();
mysqli_close($db_connect);

$_SESSION['nickname'] = $row['nickname'];
$_SESSION['date_of_birth'] = $row['date_of_birth'];
$_SESSION['avatar_url'] = $row['avatar_url'];

echo json_encode([
    'success' => true,
    'nickname' => $row['nickname'],
    'date_of_birth' => $row['date_of_birth'],
    'avatar_url' => $row['avatar_url']
]);

function send_error($error) {

    echo json_encode(['success' => false, 'error' => $error]);

    if (isset($db_connect)) {
        mysqli_close($db_connect);
    }

    die();
}

function write_bad_login_attempt() {

    global $db_connect;
    global $nickname;

    $ip = $_SERVER['REMOTE_ADDR'];
    $sql = "INSERT INTO bruteforce (ip, nickname) VALUES ('$ip', '$nickname')";
    $result = mysqli_query($db_connect, $sql);
}

function login_attempt_number() {

    global $db_connect;
    
    $ip = $_SERVER['REMOTE_ADDR'];
    $sql = "SELECT * FROM bruteforce WHERE ip = '$ip' AND ts >= NOW() - INTERVAL 5 MINUTE";
    $result = mysqli_query($db_connect, $sql);
    
    return mysqli_num_rows($result);
}

function flush_bad_login_attempts() {

    global $db_connect;

    $ip = $_SERVER['REMOTE_ADDR'];
    $sql = "DELETE FROM bruteforce WHERE ip = '$ip'";
    $result = mysqli_query($db_connect, $sql);
}
