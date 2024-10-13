<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        session_start();
        include 'dbcon.php';
        if(isset($_POST['report'])){
            $thread_id =  $_POST['id'];
            $desc = $_POST['desc'];
        $desc = str_replace("&", "&amp;", $desc); //sanitization 
        $desc = str_replace("<", "&lt;",  $desc); //sanitization 
        $desc = str_replace(">", "&gt;",  $desc); //sanitization
            // echo "jis post pe report ho rahi he".$thread_id ."<br>";
            $report_by =  $_SESSION['user_id'];
            // echo "jisne report ki he....". $report_by."<br>";

            $query = "SELECT * FROM thread WHERE threads_id = '$thread_id' ";
            $result = mysqli_query($conn, $query);
            if(mysqli_num_rows($result) > 0 ){
                $num = mysqli_fetch_assoc($result);
                $report_to = $num['threads_user_id'];
            }
            // echo "jispe report ki he".$report_to;
            $sql = "INSERT INTO <table_name> (`reportdesc`, `reportby`, `threadsid`, `reportto`, `date&time`) VALUES ('$desc', '$report_by', '$thread_id', '$report_to', current_timestamp() )";
            $res = mysqli_query($conn, $sql);
            echo'<script>alert("Your report is submitted..");</script>';
            // header( "refresh:0;url= https://dj.000.pe/talksta" );
            header( "refresh:0;url= https://talksta.000.pe" );

            $raman = "SELECT report_to, COUNT(*) as count FROM <tablename> GROUP BY report_to HAVING count > 5";
            $result1 = $conn->query($raman);


            if ($result1->num_rows > 0) {
                while($row = $result1->fetch_assoc()) {
                    // echo "Number " . $row["report_to"]. " occurs more than 5 times.<br>";
                    echo $report_to;
                    $quer = "UPDATE `user` SET block = '1' WHERE `user_id` = '$report_to' ";
                    $rama = mysqli_query($conn, $quer);
                    // if($rama) echo 'h';
                    header( "refresh:0;url= https://talksta.000.pe/" );
                }
            } 

            $raman1 = "SELECT report_by, COUNT(*) as count FROM <tablename> GROUP BY report_by HAVING count > 5";
            $result2 = $conn->query($raman1);

            if ($result2->num_rows > 0) {
                while($row = $result2->fetch_assoc()) {
                    // echo "Number " . $row["report_to"]. " occurs more than 5 times.<br>";
                    echo $report_by;
                    $quer = "UPDATE `user` SET block = '1' WHERE `user_id` = '$report_by' ";
                    $rama = mysqli_query($conn, $quer);
                    // if($rama) echo 'h';
                    header( "refresh:0;url= https://talksta.000.pe/" );
                }
            }
        }
        if(isset($_POST['reportc'])){
            $desc = $_POST['desc'];
            $comment_id =  $_POST['id'];
            $report_by =  $_SESSION['user_id'];
            $query = "SELECT * FROM comments WHERE `comment_id` = '$comment_id' ";
            $result = mysqli_query($conn, $query);
            if(mysqli_num_rows($result) > 0 ){
                $num = mysqli_fetch_assoc($result);
                $report_to = $num['comment_by'];
            }
            // echo "jispe report ki he".$report_to;
            $sql = "INSERT INTO <tablename> (`reportdesc`, `reportby`, `commentid`, `reportto`, `date&time`) VALUES ('$desc', '$report_by', '$comment_id', '$report_to',current_timestamp() )";
            $res = mysqli_query($conn, $sql);
            echo'<script>alert("Your report is submitted..");</script>';
            // header( "refresh:0;url= https://dj.000.pe/talksta" );
            header( "refresh:0;url= https://dj.000.pe/talksta" );

           $raman = "SELECT report_to, COUNT(*) as count FROM <tablename> GROUP BY report_to HAVING count > 5";
            $result1 = $conn->query($raman);

            if ($result1->num_rows > 0) {
                while($row = $result1->fetch_assoc()) {
                    // echo "Number " . $row["report_to"]. " occurs more than 5 times.<br>";
                    echo $report_to;
                    $quer = "UPDATE `user` SET block = '1' WHERE `user_id` = '$report_to' ";
                    $rama = mysqli_query($conn, $quer);
                    // if($rama) echo 'h';
                    header( "refresh:0;url= https://talksta.000.pe/talksta" );
                }
            } 
        }
    }
    else{
        header("location:https://talksta.000.pe/");
    }
?>
