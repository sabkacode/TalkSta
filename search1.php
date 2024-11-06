<?php
    error_reporting(0);
    session_start(); 

    include 'dbcon.php';
    include 'header.php';

    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        
        $sql = "SELECT * FROM thread WHERE thread.threads_title LIKE '%$search%'
                OR thread.threads_desc LIKE '%$search%' ";
        
        //$sql= "SELECT * FROM `thread` WHERE `threads_title` like ('%$search%')";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)){
            $title = $row['threads_title'];
            $desc = $row['threads_desc'];
            $tid = $row['threads_id'];
            $url = "https://dj.000.pe/talksta/thread.php?threadid=".$tid;
        }
    }
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Search-<?php echo $search; ?></title>
</head>

<body>
    <?php 
        echo'
            <div class="container mt-3">
            <h1 class="py-3">Search results for: <em>"'.$search .'"</em></h1>
                <div class="result">
                    <h3><a class="text-dark" href="'.$url.'">'.$title.'</a></h3>
                    <p>'.$desc.'</p>
                </div>
            </div>
            ';
    ?>


    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
</body>
</html>
