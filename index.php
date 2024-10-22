<?php
error_reporting(0);
session_start(); 

    // print_r($_SERVER);
    $request = $_SERVER['REQUEST_URI'];
    // echo $request;
    $router = str_replace('https://dj.000.pe/talksta', '', $request);
    // echo $router;
    if($router == '/index'){
        include('index.php');
    }
    elseif($router == '/contact'){
        include('contact.php');
    } 
    // elseif($router == '/home3'){
    //     include('home3.php');
    // }
    // elseif($router == '/threads' || preg_match("/threads\/[0-9]/i", $router)){
    //     include('threads.php');
    // }
    else{
        include('404.php');
    }

    include 'dbcon.php';
    $user_name = $_SESSION['user_name'];
    $id = $_SESSION['user_id'];

$sql = "SELECT * FROM `table` WHERE `user_name` = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $user_name);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);     
    $block = $row['block'];
}

$showPopup = false;
if ($block == 1) {
    $showPopup = true;
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style>
        @media (min-width:1024px){
            #img{
                width:100%;
                height:550px;
            }
        }
    </style>
    <title>SabkaCode</title>
</head>

<body>
    <?php 
        include 'dbcon.php';
        include 'header.php';
    ?>
    <!-- slider start -->
    <center><div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="uploads/p1.jpg"  id="img" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="uploads/p3.jpg" id="img" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="uploads/p4.jpg" id="img" class="d-block w-100" alt="...">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <!-- category -->
    <div class="container mt-3">
        <h2 class="text-center">Categories</h2>
        <div class="row mt-4">
            <!-- fetch all categories -->
            <!-- using loop to seeing the all categories -->

            <?php
                $sql = "SELECT * FROM `categories` ";
                $result = mysqli_query($conn, $sql);
                while($row = mysqli_fetch_assoc($result)){
                    // echo $row['category_id'];
                    $id =  $row['category_id'];
                    $sub = $row['category_name'];
                    $desc = $row['category_desc'];
                    $img = $row['img'];
                    echo '
                    <div class="col-md-4 mt-3">
                        <div class="card" style="width: 18rem;">
                            <img src="uploads/'.$img.'" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title"><a href="threads.php?subid='.$id.'">'.$sub.'</a></h5>
                                <p class="card-text">'.substr($desc, 0, 100).'...</p>
                                <a href="threads.php?subid='.$id.'" class="btn btn-primary">Explore More</a>
                            </div>
                        </div>
                    </div>
    
                    ';
                }
            ?>
        </div>
    </div></center>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-custom">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Important Message</h5>
                </div>
                <div class="modal-body">
                    Your account has been block.<br>
                    Contact us for reopen your account <a href="https://t.me/sabkacode"><i class="fa-brands fa-telegram" style="color: #478ff; width:25px; font-size:1.3em;"></i></a>
                </div>
            </div>
        </div>
    </div>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/02f4bd7d60.js" crossorigin="anonymous"></script>
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
</body>
</html>
