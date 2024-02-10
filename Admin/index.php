<?php
session_start();
include("./../connection.php");
$msg = '';
// echo session_id();
if (isset($_SESSION['user'])) {
    // header('Location: ./main.php');
}
if (isset($_POST['submit'])) {
    $sql = select("admin", ['email' => $_POST['email'], 'password' => $_POST['password']]);
    try {
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $_SESSION['admin'] = $result->fetch_array()['id'];
            header('Location: ./main.php');
        } else {
            $msg = "* Wrong email or password";
        }
    } catch (Exception $e) {
        die('Error: ' . $e->getMessage());
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <style>
        .form-container {
            width: max(30%, 300px);
            /* height: 400px; */
            margin: 20px auto;
            background-color: lightblue;
            border-radius: 30px;
            padding: min(40px, 10%);
        }
        .form-container > p{
            margin-top: 20px;
        }
        .login a{
            text-decoration: none;
            color: black;
        }
    </style>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="./../logo.jpg" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
                    Helios Selene
                </a>
            </div>
        </nav>
    </header>
    <div class="body-container">
        <div class="form-container">
            <h3 style='text-align: center;'>Admin Login</h3>
            <form action="" method="post">
                <div class="mb-3">
                    <label for="formGroupExampleInput" class="form-label">Email</label>
                    <input type="email" required class="form-control" name="email" id="formGroupExampleInput">
                </div>
                <div class="mb-3">
                    <label for="formGroupExampleInput2" class="form-label">Password</label>
                    <input type="password" required class="form-control" name="password" id="formGroupExampleInput2">
                </div>
                <p style='color: red;'>
                    <?php echo $msg ?>
                </p>
                <div class="col-12">
                    <input type="submit" value="Sign in" name="submit" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
</body>

</html>