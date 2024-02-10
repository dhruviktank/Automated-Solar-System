<?php
include("connection.php");

$msg = "";
if (isset($_POST['submit'])) {
    $data = $_POST['user'];
    $result = $conn->query(select("users", ['email' => $data['email']]));
    if ($result->num_rows > 0) {
        $msg = "*User with email already exist try to login";
    } else {
        $sql = insert("users", $data);
        try {
            $conn->query($sql);
            header("Location: ./");
        } catch (Exception $e) {
            echo "" . $e->getMessage();
        }
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
            width: max(40%, 300px);
            /* height: 400px; */
            margin: 20px auto;
            background-color: lightblue;
            border-radius: 30px;
            padding: min(40px, 5%);
        }

        .form-container>p {
            margin-top: 20px;
        }

        a {
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
                    <img src="logo.jpg" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
                    Helios Selene
                </a>
                <div class="login">
                    <a href="./">Login</a>
                </div>
            </div>
        </nav>
    </header>
    <div class="form-container">
        <form class="row g-3" action="" method="post">
            <h3 style='text-align: center'>Register</h3>
            <div class="col-md-6">
                <label for="inputEmail4" class="form-label">FirstName</label>
                <input type="text" name="user[first_name]" required class="form-control" id="inputEmail4">
            </div>
            <div class="col-md-6">
                <label for="inputPassword4" class="form-label">LastName</label>
                <input type="text" name="user[last_name]" required class="form-control" id="inputPassword4">
            </div>
            <div class="col-12">
                <label for="inputAddress" class="form-label">Username</label>
                <input type="text" class="form-control" required name="user[username]" id="inputAddress">
            </div>
            <div class="col-12">
                <label for="inputAddress2" class="form-label">Phone No</label>
                <input type="text" class="form-control" required name="user[phone_no]" id="inputAddress2">
            </div>
            <div class="col-12">
                <label for="inputemail" class="form-label">Email</label>
                <input type="email" class="form-control" required name="user[email]" id="inputemail">
            </div>
            <div class="col-12">
                <label for="password1" class="form-label">password</label>
                <input type="password" class="form-control" required name="user[password]" id="password1">
            </div>
            <div class="col-12">
                <label for="password2" class="form-label">repeat password</label>
                <input type="password" class="form-control" required name="password_repeat" id="password2">
            </div>
            <div class="col-12">
                <div class="form-check">
                    <input class="form-check-input" required type="checkbox" id="gridCheck">
                    <label class="form-check-label" for="gridCheck">
                        Check me out
                    </label>
                </div>
            </div>
            <p style='color: red;'>
                <?php echo $msg ?>
            </p>
            <div class="col-12">
                <input type="submit" value="Register" name="submit" class="btn btn-primary">
            </div>
        </form>
    </div>
</body>

</html>