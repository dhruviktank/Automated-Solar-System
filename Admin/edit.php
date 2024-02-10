<?php
include("./../connection.php");
session_start();
if(isset($_GET['edit'])){
    $uid = $_GET['id'];
    $sql = select("users", ['id'=>$uid]);
    $user = $conn->query($sql)->fetch_assoc();
}

if(isset($_POST['update'])){
    $new_data = $_POST['user'];
    if(!empty($_FILES["fileUpload"]["tmp_name"])){
        $image = updateImage($_FILES["fileUpload"]);
        $sql = update("users", ["image"=>$image], ["id"=>$uid]);
        $conn->query($sql);
    }
    $new_data = array_filter($new_data, function($val, $key){
        global $user;
        return ($user[$key] != $val);
    }, ARRAY_FILTER_USE_BOTH);
    if(!empty($new_data)){
        $sql = update("users", $new_data, ["id"=>$uid]);
        $conn->query($sql);
    }
    header("Location: edit.php?edit=1&id=$uid");
}

function updateImage($image){
    $imageExt = strtolower(pathinfo($image["name"], PATHINFO_EXTENSION));
    $tempname = $image["tmp_name"];
    global $user;
    $filename = "profile_".$user['id'].".".$imageExt;
    $targetFile = "./../image/" . $filename;
    move_uploaded_file($tempname, $targetFile);
    return $filename;
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
            background-color: lightblue;
            padding: 30px;
            border-radius: 20px;
            width: max(40%, 300px);
            margin: 0 auto;
        }
        .left{
            width: fit-content;
            padding: 10px;
            border-radius: 10px;
            transition: all .3s ease;
        }
        .left:hover{
            background-color: lightblue;
        }
        .image-preview{
            margin: 20px auto;
            height: 150px;
            width: 150px;
            border-radius: 50%;
            border: 5px solid gray;
        }
        .image-preview img{
            height: 100%;
            width: 100%;
            object-fit: cover;
            border-radius: 50%;
        }
    </style>
</head>

<body>
    <div class="left" style="margin: 30px">
        <a href="main.php"><img src="./../left.png" width="30" alt="left"></a>
    </div>
    <div class="form-container">
        <h3 style="text-align: center;">User Details</h3>
        <div class="image-preview">
        <img src="<?php echo ((!is_null($user['image'])) ? ((file_exists('./../image/'.$user['image'])) ? './../image/'.$user['image'] : "./../profile.jpg") : "./../profile.jpg" ) ?>" alt="preview">
        </div>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="formFile" class="form-label">Choose Profile Picture</label>
                <input class="form-control" name="fileUpload" type="file" id="formFile">
            </div>
            <div class="row">
                <div class="col">
                    <label for="inputAddress" class="form-label">First name</label>
                    <input type="text" class="form-control" name="user[first_name]" value="<?= $user['first_name'] ?>" aria-label="First name">
                </div>
                <div class="col">
                    <label for="inputAddress" class="form-label">Last Name</label>
                    <input type="text" class="form-control" name="user[last_name]" 
                    value="<?= $user['last_name'] ?>" aria-label="Last name">
                </div>
            </div>
            <div class="col-12">
                <label for="inputAddress" class="form-label">username</label>
                <input type="text" class="form-control" value="<?= $user['username'] ?>" name="user[username]" id="inputAddress"
                    placeholder="1234 Main St">
            </div>
            <div class="col-12">
                <label for="inputAddress2" class="form-label">Phone No</label>
                <input type="text" class="form-control" value="<?= $user['phone_no'] ?>" name="user[phone_no]" id="inputAddress2"
                    placeholder="Apartment, studio, or floor">
            </div>
            <div class="col-12">
                <label for="inputemail" class="form-label">Email</label>
                <input type="email" class="form-control" value="<?= $user['email'] ?>" name="user[email]" id="inputemail">
            </div>
            <div class="col-12">
                <label for="password1" class="form-label">password</label>
                <input type="password" class="form-control" value="<?= $user['password'] ?>" name="user[password]" id="password1">
            </div>
            <div class="col-12" style="margin: 20px 0">
                <input type="submit" value="Update" name="update" class="btn btn-primary">
            </div>
        </form>
    </div>
</body>

</html>