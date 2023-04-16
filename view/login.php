<?php

// require a secure connection
 $https = filter_input(INPUT_SERVER, 'HTTPS');
     if (!$https) {
            $host = filter_input(INPUT_SERVER, 'HTTP_HOST');
            $uri = filter_input(INPUT_SERVER, 'REQUEST_URI');
            $url = 'https://' . $host . $uri;
            header("Location: " . $url);
            exit();
     }
     
include './view/shared/header.php';
include './view/shared/nav.php';
?>
<main>
    <h2>Login</h2>

    <form action="." method="post" id="login_form" class="aligned">

        <label>Username:</label>
        <input type="text" class="text" name="username">
        <br>

        <label>Password:</label>
        <input type="password" class="text" name="password">
        <br>

        <label>&nbsp;</label>
        <input type="submit" name="action" value="Login">
    </form>

    <p><?php echo $login_message; ?></p>
</main>
</body>
</html>

