<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="loader.css">
</head>

<body>
    <section class="login_success success hide hidden">Successfully logged in!</section>
    <section class="main">
        <div class="loader_wrap wrap">
            <span class="loader"></span>
        </div>
        <div class="login wrap hide hidden">
            <h1 class="login_title title">Login</h1>
            <div class="login_form_wrap">
                <div class="login_error error hide hidden"></div>
                <form class="login_form" action="auth.php" method="POST">
                    <input class="input" type="text" id="nickname" name="nickname" placeholder="Login"><br>
                    <input class="input" type="password" id="password" name="password" placeholder="Password">
                    <input class="button" type="submit" value="Login">
                    <input type="hidden" name="session" value="<?= isset($_GET['session']) ? $_GET['session'] : '' ?>">
                </form>
            </div>
        </div>
        <div class="user wrap hide hidden">
            <div class="user_photo"><img src="" alt=""></div>
            <div class="user_title title"></div>
            <div class="user_info"></div>
            <button class="user_logout button">Logout</button>
        </div>
    </section>
</body>

<script type="text/javascript" src="script.js"></script>

</html>