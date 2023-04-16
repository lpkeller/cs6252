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
    <h2>Welcome to the Task Manager Application</h2>
</main>
</body>
</html>