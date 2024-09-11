<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            text-align: center;
            padding: 20px;
        }
        header img {
            width: 100%;
            height: auto;
            display: block;
        }
        .login-options {
            margin-top: 50px;
        }
        .login-options a {
            display: inline-block;
            margin: 0 15px;
            padding: 15px 30px;
            text-decoration: none;
            color: white;
            background-color: #4CAF50;
            border-radius: 5px;
            font-size: 18px;
            transition: background-color 0.3s ease;
        }
        .login-options a:hover {
            background-color: #45a049;
        }
        @media (max-width: 600px) {
            .login-options a {
                display: block;
                margin: 10px auto;
                width: 80%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <img src="images/SchoolBanner.png" alt="Banner Image">
        </header>
        <div class="login-options">
            <a href="login.php?usertype=ADMIN">ADMIN</a>
            <a href="login.php?usertype=USER">USER</a>
        </div>
    </div>
</body>
</html>
