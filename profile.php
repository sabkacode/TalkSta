<?php
    error_reporting(0);
    session_start();
    include('dbcon.php');

    $msg = false;
    $request = $_SERVER['REQUEST_URI'];
    $router = str_replace('/talksta/', '', $request);

    if ($router) {
        $sql = "SELECT * FROM <table> WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $router);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        $target_id = $row['user_id']; //page wala
        $desc = $row['user_desc'];
        $url1 = $row['url1'];
        $url2 = $row['url2'];
        $url3 = $row['url3'];
        $url4 = $row['url4'];
        $url5 = $row['url5'];
        $hidden = $row['cts'];

        if ($row) {
            $msg = true;
        } else {
            echo '<center><h1>No user found with the name ' . htmlspecialchars($router) . '</h1></center>';
            exit();
        }
    }

    $user_name = $row['user_name'];
    $id = $row['user_id'];

    $sql = "SELECT * FROM `<table>` WHERE `username` = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $user_name);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $user_email = $row['useremail'];
        $name = $row['name'];
        $image = $row['image'];
    }

    $sql1 = "SELECT * FROM `<table>` WHERE `threadsuserid` = ?";
    $stmt1 = mysqli_prepare($conn, $sql1);
    mysqli_stmt_bind_param($stmt1, "i", $id);
    mysqli_stmt_execute($stmt1);
    $result1 = mysqli_stmt_get_result($stmt1);
    $got1 = true;

    $sql2 = "SELECT * FROM `<table>` WHERE `commentby` = ?";
    $stmt2 = mysqli_prepare($conn, $sql2);
    mysqli_stmt_bind_param($stmt2, "i", $id);
    mysqli_stmt_execute($stmt2);
    $result2 = mysqli_stmt_get_result($stmt2);
    $got2 = true;

    include 'header.php';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo htmlspecialchars($user_name); ?> - Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">
    <style>
        .container1 {
            display: flex;
            max-width: 100%;
            width: 100%;
        }
        .left {
            flex: 0.6;
            text-align: center;
            align-items: center;
        }
        .right {
            flex: 1;
            padding: 20px;
        }
        .profile-pic {
            width: 70%;
            border-radius: 50%;
            cursor: pointer;
            margin-top: 20%;
        }
        .r {
            margin-top: 8%;
            font-size: 16px;
        }
        .comment {
            margin-top: 7%;
        }
        .jumbo {
            padding: 1rem 1rem;
            background-color: #e9ecef;
        }
    </style>
</head>
<body>
    <div class="container1">
        <div class="left">
            <img class="profile-pic"  src="<?php echo 'profiles/images/' . htmlspecialchars($image); ?>" alt="Profile Picture"><br><br>
            <p><strong>Username: </strong><?php echo htmlspecialchars($user_name); ?></p>
            <?php 
                if(!empty($desc)){
                    echo "<p><strong>Desc: </strong>" .$desc;
                }    
            ?>
        </div>
        <div class="right">
            <div class="r">
                <p><strong>Name:</strong> <?php echo htmlspecialchars($name); ?></p>
                <p><strong>Email:</strong> <?php if ($hidden == 0) echo htmlspecialchars($user_email); else echo 'Email is hidden'; ?></p>
            </div>
            <div class="contact">
                <h5>Contact Us:</h5>
                <a href="https://dj.000.pe/talksta/<?php echo htmlspecialchars($user_name); ?>">
                    <img src="me.png" width="35" height="35" style='margin-top:10px'>
                </a> 
                <?php if (!empty($url1)) echo '<a href="'.$url1.'"><i class="fa-brands fa-github" style="color: #478bff; width:25px; font-size:1.3em;"></i></a>'; ?>
                <?php if (!empty($url2)) echo '<a href="'.$url2.'"><i class="fa-brands fa-x-twitter" style="color: #478bff; width:20px; font-size:1.3em;"></i></a>'; ?>
                <?php if (!empty($url3)) echo '<a href="'.$url3.'"><img src="Image.png" width="24" height="23" style="margin-top:-6px"></a>'; ?>
                <?php if (!empty($url4)) echo '<a href="'.$url4.'"><i class="fa-brands fa-telegram" style="color: #478ff; width:25px; font-size:1.3em;"></i></a>'; ?>
                <?php if (!empty($url5)) echo '<a href="'.$url5.'"><i class="fa-brands fa-linkedin-in" style="color: #478ff; width:25px; font-size:1.3em;"></i></a>'; ?>
            </div>
            <br>
           <?php

                $shiv = "SELECT followers, following FROM user WHERE user_id = '$target_id'";
                $shiva = mysqli_query($conn, $shiv);

                if ($shiva) {
                    $rows = mysqli_fetch_assoc($shiva);
                    $followerCount = $rows['followers'];
                    $followingCount = $rows['following'];
                } 
                ?>

            <div class="follows" style="display:flex;">
                <h6>
                    <form action="" method="POST">
                        <button onmouseover="this.style.color='blue';" onmouseout="this.style.color='#3b7add';" style="outline:none; text-decoration:none; font-weight:bold; color:#3b7add; background-color:transparent; border:none;" name="following">Following: <span><?php echo $followingCount; ?></span></button>
                        <input type="hidden" name="target_id" value="<?php echo $target_id;?>">
                        <button onmouseover="this.style.color='blue';" onmouseout="this.style.color='#3b7add';" style="outline:none; text-decoration:none; font-weight:bold; color:#3b7add; background-color:transparent; border:none;" name="followers">Followers: <span><?php echo $followerCount; ?></span></button>
                    </form>
                </h6>
            </div>

            <?php                 

                // Check if user is logged in
                if (isset($_SESSION['user_id'])) {

                        $check = "select follow_to, following_by from follow";
                        $check1 = mysqli_query($conn, $check);
                        $count_follow_to = array();
                        $count_following_by = array();
                        while($check2 = $check1->fetch_assoc()){
                            // echo $check2['follow_to'];
                            // echo "-".$check2['following_by']."<br>";
                            $count_follow_to[] = $check2['follow_to'];
                            $count_following_by[] = $check2['following_by'];
                        }

                        $match_found = false;
                        for ($i = 0; $i < count($count_follow_to); $i++) {
                            if ($count_follow_to[$i] == $target_id && $count_following_by[$i] == $_SESSION['user_id']) {
                                $match_found = true;
                            }
                        }
                        
                        if(!$match_found){
                            echo'
                                <form action="#" method="POST">
                                    <button type="submit" id="followBtn" name="followBtn" class="btn btn-success my-2 my-sm-0">Follow</button>
                                </form>
                            ';
                        }
                        else{
                            echo'
                                <form action="#" method="POST">
                                    <button type="submit" id="unfollowBtn" name="unfollowBtn" class="btn btn-success my-2 my-sm-0">Unfollow</button>
                                </form>
                            ';
                        }
                        echo'
                            </form>
                        ';
                }
                else{
                    echo'
                        <button type="submit" id="followBtn" name="followBtn" data-toggle="modal" id="openPopup" data-target="#report" name="click11" onclick="fac" class="btn btn-success my-2 my-sm-0">Follow</button>
                    ';
                }

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    session_start();
                    // Ensure the target_id is set and session has user_id
                    if(isset($_POST['followBtn'])){
                        if (isset($_SESSION['user_id']) && isset($target_id)) {
                            $u_id = $_SESSION['user_id'];
                            $t_id = $target_id;
                            
                            // Debugging output
                            // echo "User ID: " . $u_id . " Target ID: " . $t_id;

                            // Prepare and execute the SQL query
                            $a = "INSERT INTO follow (follow_to, following_by) VALUES ('$t_id', '$u_id')";
                            $a1 = mysqli_query($conn, $a);

                            
                            // Check if the query was successful
                            if ($a1) {
                                echo "Followed successfully!";

                                $follow = "SELECT follow_to, COUNT(follow_to) as count FROM follow GROUP BY follow_to ORDER BY follow_to";
                                $following = "SELECT following_by, COUNT(following_by) as counting FROM follow GROUP BY following_by ORDER BY following_by";
                                $follow1 = $conn->query($follow);
                                $following1 = $conn->query($following);
                                if ($follow1->num_rows > 0) {

                                    while($follow2 = $follow1->fetch_assoc()) {
                                        // echo "<br>Digit " . $follow2["follow_to"] . " appears " . $follow2["count"] . " times.";
                                    
                                        $user_id =  $follow2["follow_to"];
                                        $followers = $follow2['count'];
                                        $data_transfer = "UPDATE user SET followers='$followers' WHERE user_id='$user_id'";
                                        $data_transfer1 = mysqli_query($conn, $data_transfer);
                                        // echo "userid".$user_id;
                                    }
                                }

                                if ($following1->num_rows > 0) {
                                
                                    while($following2 = $following1->fetch_assoc()) {
                                        // echo "<br>Digit " . $following2["following_by"] . " appears " . $following2["counting"] . " times.";
                                    
                                        $user_id =  $following2["following_by"];
                                        $following = $following2['counting'];
                                        $data_transfer = "UPDATE user SET following='$following' WHERE user_id='$user_id'";
                                        $data_transfer1 = mysqli_query($conn, $data_transfer);
                                        // echo "userid".$user_id;
                                        echo "<script>
                                                setTimeout(function() {
                                                    window.location.href='https://dj.000.pe{$router}';
                                                }, 1000);
                                            </script>";
                                    }
                                }
                            }
                        } 
                    }

                    if(isset($_POST['unfollowBtn'])){
                        if (isset($_SESSION['user_id']) && isset($target_id)) {
                            $u_id = $_SESSION['user_id'];
                            $t_id = $target_id;

                            // Delete the follow record
                            $b = "DELETE FROM follow WHERE follow_to = '$t_id' AND following_by = '$u_id'";
                            $b1 = mysqli_query($conn, $b);
                            
                            if($b1){
                                echo 'Unfollowed Successfully';

                                // Update the following count for the user
                                $b2 = "UPDATE user SET following = following - 1 WHERE user_id = '$u_id'";
                                // Update the followers count for the target user
                                $b3 = "UPDATE user SET followers = followers - 1 WHERE user_id = '$t_id'";

                                $b2_2 = mysqli_query($conn, $b2);
                                $b3_3 = mysqli_query($conn, $b3);

                                // Check if both updates were successful
                                if($b2_2 && $b3_3){
                                    // echo 'Counts updated successfully';
                                } else {
                                    // echo 'Error updating counts';
                                }
                                
                                // Redirect after unfollow
                                echo "
                                    <script>
                                        setTimeout(function() {
                                            window.location.href='https://dj.000.pe{$router}';
                                        }, 1000);
                                    </script>";
                            } else {
                                // echo 'Error unfollowing';
                            }
                        }
                    }
                }
                
                    // else {
                    //     // Debugging output if variables are not set
                    //     echo "Session user_id or target_id not set.";
                    // }

            ?>
            

            <br>
            <?php
                // include 'dbcon.php';
                $id = $_POST['target_id'];

                if (isset($_POST['following'])) {
                    // echo 'yes';
                    $sql = "SELECT follow_to FROM follow WHERE following_by = '$id'";
                    $query = mysqli_query($conn, $sql);

                    if ($query) {
                        $user_id = []; 
                        while ($rows = mysqli_fetch_assoc($query)) {
                            $user_id[] = $rows['follow_to'];
                        }

                        if (count($user_id) > 0) {
                            foreach ($user_id as $uid) {
                                $data = "SELECT * FROM user WHERE user_id = '$uid'";
                                $fetch = mysqli_query($conn, $data);
                                $row = mysqli_fetch_assoc($fetch);

                                if ($row) {
                                    echo '
                                        <table">
                                            <tr>
                                                <td>' . $row['user_name'] . '</td>
                                                <td>' . $row['user_name'] . '</td>
                                            </tr>
                                        </table><br>
                                    ';
                                } 
                            }
                        } 
                        else {
                            echo '<p>No followers found.</p>';
                        }
                    } 
                }

                if(isset($_POST['followers'])){
                    $sql = "SELECT following_by FROM follow WHERE follow_to = '$id'";
                    $query = mysqli_query($conn, $sql);

                    if ($query) {
                        $user_id = []; 
                        while ($rows = mysqli_fetch_assoc($query)) {
                            $user_id[] = $rows['following_by'];
                        }

                        if (count($user_id) > 0) {
                            foreach ($user_id as $uid) {
                                $data = "SELECT * FROM user WHERE user_id = '$uid'";
                                $fetch = mysqli_query($conn, $data);
                                $row = mysqli_fetch_assoc($fetch);

                                if ($row) {
                                    echo '
                                        <table">
                                            <tr>
                                                <td>' . $row['user_name'] . '</td>
                                            </tr>
                                        </table><br>
                                    ';
                                } 
                            }
                        } 
                        else {
                            echo '<p>No followers found.</p>';
                        }
                    } 
                }
            ?>
            <br>
            <h5>Threads:</h5>
            <div class="jumbo">
                <?php
                $sno = 0;
                while ($row = mysqli_fetch_assoc($result1)) {
                    $got1 = false;
                    $tid = $row['threads_id'];
                    $title = $row['threads_title'];
                    $desc = $row['threads_desc'];
                    $comment_time = $row['datetime'];
                    $date = new DateTime($comment_time);
                    $date1 = $date->format('d-m-Y');
                    $sno++;
                ?>
                    <div class="media">
                        <div class="media-body">
                            <div style="display:flex; justify-content: space-between;">
                                <h5 class="my-0" style="font-size:1.2rem;"><a class="text-dark" href="https://dj.000.pe/talksta/thread.php?threadid=<?php echo $tid; ?>"><?php echo $sno . ". " . htmlspecialchars($title); ?></a></h5>
                                <p style="font-size:14px" class="font-weight-bold text-right my-0"><?php echo $date1; ?></p>
                            </div>
                            <?php echo htmlspecialchars($desc); ?>
                        </div>
                    </div>
                <?php
                }
                if ($got1) {
                ?>
                    <div class="jumbo">
                        <div class="container">
                            <h5>No Threads Found</h5>
                            <p class="lead">Be the first person to ask a question</p>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
    <div class="modal fade" id="report" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="loginModalLabel">Alert - Talk Sta</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <p>
                                                Your are not login!! Please login first.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/02f4bd7d60.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"></script>
</body>
</html>
<script>
// document.getElementById('followBtn').addEventListener('click', function() {
//     var btn = this;
//     if (btn.classList.contains('follow')) {
//         btn.classList.remove('follow');
//         btn.classList.add('unfollow');
//         btn.textContent = 'Unfollow';
//     } else {
//         btn.classList.remove('unfollow');
//         btn.classList.add('follow');
//         btn.textContent = 'Follow';
//     }
// });
</script>
<script>
    $(document).ready(function() {
        var showPopup = <?php echo json_encode($showPopup); ?>;
        if (showPopup) {
            $('#myModal').modal({
            backdrop: 'static',
            keyboard: false
        });
        $('#myModal').modal('show');
        }
    });
</script>
