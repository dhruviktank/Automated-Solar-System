<?php
session_start();
include("./../connection.php");

$sql = select("users");
try {
    $users = $conn->query($sql)->fetch_all(MYSQLI_ASSOC);
} catch (Exception $e) {
    echo $e->getMessage();
}

if (isset($_GET['remove'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM users WHERE `id` = '$id'";
    $conn->query($sql);
    header("Location: ./main.php");
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
        table,
        tr,
        td,
        th {
            border: 1px solid black;
            border-collapse: collapse;
        }
        table{
            background-color: lightblue;
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

    <h1 style="text-align: center;">User Data</h1>
    <table class="table table-primary" style="background: lightblue;">
        <tr>
            <th>Id</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Username</th>
            <th>Phone no</th>
            <th>Email</th>
            <th>Password</th>
            <th></th>
            <th></th>
        </tr>
        <?php foreach ($users as $user):
            $id = $user['id'] ?>
            <tr>
                <td>
                    <?= $user['id']; ?>
                </td>
                <td>
                    <?= $user['first_name']; ?>
                </td>
                <td>
                    <?= $user['last_name']; ?>
                </td>
                <td>
                    <?= $user['username']; ?>
                </td>
                <td>
                    <?= $user['phone_no']; ?>
                </td>
                <td>
                    <?= $user['email']; ?>
                </td>
                <td>
                    <?= $user['password']; ?>
                </td>
                <td><a href="main.php?remove=1&id=<?= $id; ?>"><button>Remove</button></a></td>
                <td><a href="edit.php?edit=1&id=<?= $id; ?>"><button>Update</button></a></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>