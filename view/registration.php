<?php

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
    <h2>Registration</h2>

    <form action="." method="post" id="registration_form" class="aligned">

        
        <label>Username:</label>
        <input type="text" class="text" name="username">
        <p><small>Username must be between 1 and 20 characters. </small></p>
        <br>

        
        <label>Password:</label>
        <input type="password" class="text" name="password">
        <p><small>Your Password must contain at least 1 number, 1 uppercase letter, 1 lowercase letter, 
                <br> and be at least 8 characters long.</small> </p>
        <br>

        <label>&nbsp;</label>
        <input type="submit" name="action" value="Register">
        
    </form>
    <br>
    <p style="color:red"><?php echo $reg_error_message; ?></p>
    
</main>
</body>
</html>

