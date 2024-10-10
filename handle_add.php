<?php
    include 'dbcon.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $title = $_POST['title'];
        $desc = $_POST['desc'];
        $img = $_POST['img'];

        // Directory where the image will be saved
        $target_dir = "uploads/";  // Make sure this directory exists and is writable
        $file_name = basename($_FILES['img']['name']);
        $target_file = $target_dir . $file_name;
        $file_tmp = $_FILES['img']['tmp_name'];
        $file_type = $_FILES['img']['type'];
        $file_size = $_FILES['img']['size'];

        // Allow certain file formats
        $allowed = array('jpg', 'jpeg', 'png', 'gif');
        $file_ext = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if (in_array($file_ext, $allowed)) {
            // Move the uploaded file to the target directory
            if (move_uploaded_file($file_tmp, $target_file)) {
                // Insert the data into the database
                $sql = "INSERT INTO `categories` (`category_name`, `category_desc`, `img`, `datetime`) VALUES (?, ?, ?, current_timestamp())";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sss", $title, $desc, $target_file);

                if ($stmt->execute()) {
                    echo "<script>alert('Insert successfully');</script>";
                    // header("refresh:0; url=https://dj.000.pe/talksta");
                } else {
                    echo "<script>alert('Not insert, some problem...');</script>";
                    // header("refresh:0; url=https://dj.000.pe/talksta");
                }

                $stmt->close();
            } else {
                echo "<script>alert('Sorry, there was an error uploading your file.');</script>";
                // header("refresh:0; url=https://dj.000.pe/talksta");
            }
        } else {
            echo "<script>alert('Invalid file format. Only JPG, JPEG, PNG, & GIF are allowed.');</script>";
            // header("refresh:0; url=https://dj.000.pe/talksta");
        }
    } else {
        echo "<script>alert('Accha, maje le raha he!!');</script>";
        // header("refresh:0; url=https://dj.000.pe/talksta");
    }

    $conn->close();
?>
