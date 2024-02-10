<?php
include("connection.php");
session_start();
$currentVoltage = "200";
$currentPower = "300";

$lastVoltage = "100";
$lastPowerGenerated = "250";
$lastCleanTime = date("Y-m-d h:i:sa");
$waterTankLevel = 50;
$nextClenaTime = date('Y-m-d h:i:sa', strtotime(' + 4 months'));
if (isset($_SESSION['user'])) {
    $uid = $_SESSION['user'];
    $sql = select("users", ['id' => $uid]);
    $user = $conn->query($sql)->fetch_assoc();
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
    <link rel="stylesheet" href="style.css">
</head>

<body onload="startTime()">
    <div class="side-nav-bar" id="side-bar">
        <div class="close-btn">
            <img src="close.png" id="close-btn" width="45" alt="close">
        </div>
        <div class="image-container">
            <img src="<?php echo ((!is_null($user['image'])) ? ((file_exists('./image/' . $user['image'])) ? './image/' . $user['image'] : "profile.jpg") : "profile.jpg") ?>"
                height="150" width="150" alt="">
        </div>
        <p style="text-align: center">
            <?php echo (!empty($user)) ? $user['first_name'] . " " . $user['last_name'] : ''; ?>
        </p>
        <button><a href="userdetails.php">User Details</a></button><br>
        <a href="./"><button>Log out</button></a>
    </div>
    <div class="alert alert-warning alert-dismissible fade show" style="display: none;width: 100%;text-align: center;position: absolute;top: 0;" role="alert">
        <strong>Warning!</strong> Water tank level is less than 30%
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <div class="">
        <div class="header" style="height: 10vh;display: flex;align-items: center;">
            <div class="logo-container"
                style="margin: 5px;padding: 10px;border-radius: 10px;display: flex;justify-content: space-between;align-items: center">
                <img height="40px" src="logo.jpg" alt="">
                <div id="menu-btn">
                    <img height="40px" src="Menu.png" alt="">
                </div>
            </div>
            <div class="title-container" style="width: 100%;">
                <h3 style='text-align: center;color: rgba(13, 110, 253, 1);'>Solar Panel Cleaning System</h3>
            </div>
        </div>
        <div class="body-container" style="display: flex;height: 68vh;">
            <div class="middle-container" style="width: 70%;height: 90%">
                <div class="panel-data" style="height: 260px">
                    <div class="start-state first" style="padding: 10px;display: block;">
                        <img src="brush.png" style="height: 20vh" alt="brush">
                        <button onclick="changeState(1)">Start</button>
                    </div>
                    <div class="start-state second" style="display: none;width: 80%; padding: 30px">
                        <button onclick="changeState(0)"
                            style="padding: 5px;background: white;color: black;font-size: 15px;width: fit-content;">
                            <</button>
                                <br>
                                <label for="duration">duration: </label>
                                <select name="duration" id="duration" style="width: 200px;margin: 10px 0;">
                                    <option value="15">15 Minute</option>
                                    <option value="25">25 Minute</option>
                                    <option value="30">30 Minute</option>
                                </select><br>
                                <label for="time">Time: </label>
                                <input type="time" required name="" id="time">
                                <input type="submit" onclick="getTimer()" value="Set">
                    </div>
                    <div class="start-state third" style="display: none;">
                        <button onclick="changeState(1)"
                            style="padding: 5px 10px;background: white;color: black;font-size: 15px;width: fit-content;">
                            <</button>
                                <p>Remaining Time: <span class="h"></span> Hours<span class="m"></span> Min</p>
                    </div>
                </div>
                <div>
                    <p style="text-align: center;padding: 5px 0;font-size: 18px">Cleaning
                        History</p>
                    <p style="text-align: center;">Last cleaned at:
                        <?= $lastCleanTime ?>
                    </p>
                </div>
            </div>
            <div class="middle-right" style="width: 30%;height: 100%">
                <div class="clock" style="text-align: center;padding: 30px;height: 40%;">
                    <img src="clock.png" width="100" alt="clock">
                    <p style="text-align: center;" id="clock"></p>
                    <p style="text-align: center;">
                        <?= date("d-F Y") ?>
                    </p>
                </div>
                <div class="start" style="padding: 30px;height: 60%;">

                </div>
            </div>
        </div>
        <div class="footer" style="height: 18vh;display: flex;">
            <div style="width: 10%;padding-top: 15px;">
                <p>copyright@2024</p>
            </div>
            <div class="next-time" style="text-align: center;width: 30%;padding: 15px;">
                <p>Next Cleaning time:
                    <?= $nextClenaTime ?>
                </p>
                <img src="Doorbell.png" style="height: 70%;" alt="doorbell">
            </div>
            <div class="tank-level" style="width: 30%;padding: 15px;">
                <p>Water tank level:
                <div class="progress" style="height: 50px" role="progressbar" aria-label="Example with label"
                    aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar" style="width: <?= $waterTankLevel . "%" ?>">
                        <?= $waterTankLevel . "%" ?>
                    </div>
                </div>
                </p>
            </div>
            <div class="feedback" style="width: 30%;box-sizing: border-box;">
                <p style="text-align: center;">Feedbacks</p>
                <form action="" method="post" style="text-align: center">
                    <input style="box-sizing:border-box;width: 50%;padding: 5px;margin: 0;" type="text" name="" id=""><br>
                    <input style="padding: 5px;margin:5px;width: 50%" type="submit" value="Submit">
                </form>
            </div>
        </div>
    </div>

    <script>
        var alert = document.getElementById('tank-alert');
        
        function getTimer() {
            calculateTime();
            var x = setInterval(calculateTime(), 60000)
            changeState(2);
        }
        function calculateTime() {
            var m = document.getElementsByClassName('m')[0]
            var h = document.getElementsByClassName('h')[0]
            var time = document.getElementById('time').value;
            var min = time.split(":")[1];
            var hours = time.split(":")[0];
            var d = new Date();
            var newtime = new Date(d.getFullYear(), d.getMonth(), d.getDate() + 1, hours, min)
            var newtimems = newtime.getTime();
            var currentdate = new Date().getTime();
            var dif = newtimems - currentdate;
            console.log(dif);
            var hours = Math.floor((dif % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((dif % (1000 * 60 * 60)) / (1000 * 60));
            m.innerHTML = minutes
            h.innerHTML = hours
            if (dif < 0) {
                clearInterval(x)
                m.innerHTML = 0
                h.innerHTML = 0
            }
        }

        function changeState(x) {
            var state = document.getElementsByClassName('start-state');
            for (var i = 0; i < state.length; i++) {
                state[i].style.display = "none";
            }
            state[x].style.display = "block";
        }

        function startTime() {
            const today = new Date();
            let h = today.getHours();
            let m = today.getMinutes();
            let s = today.getSeconds();
            m = checkTime(m);
            s = checkTime(s);
            document.getElementById('clock').innerHTML = h + ":" + m + ":" + s;
            setTimeout(startTime, 1000);
        }

        function checkTime(i) {
            if (i < 10) { i = "0" + i };  // add zero in front of numbers < 10
            return i;
        }

        function logoutUser() {
            var con = confirm("Are you sure?");
            if (con) {
                return true;
            }
            else {
                return false;
            }
        }
        var closebtn = document.getElementById('close-btn');
        var menubtn = document.getElementById('menu-btn');
        var sidebar = document.getElementById('side-bar');
        console.log(sidebar);
        closebtn.addEventListener('click', () => {
            sidebar.style.left = '-400px';
        })
        menubtn.addEventListener('click', () => {
            sidebar.style.left = '0';
        })
    </script>
</body>

</html>