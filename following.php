<?php
    include 'dbcon.php';
    $id =  $_REQUEST['t_id'];
    $sql = "select follow_to from follow where following_by = '$id' ";
    $query = mysqli_query($conn, $sql);
    if($query){
        while($rows = mysqli_fetch_assoc($query)){
            $user_id[] =  $rows['follow_to'];
        }

        for($i=0;$i<count($user_id);$i++){
            // echo $user_id[$i];
            $data = "select * from user where user_id = '$user_id[$i]'";
            $fetch = mysqli_query($conn, $data);
            $row = mysqli_fetch_assoc($fetch);
            if($fetch){
                echo'
                    <table border="1px solid black">
                        <tr>
                            <td>'.$row['user_name'].'</td>
                        </tr>
                    </table>
                ';
            }
        }
    }

?>
