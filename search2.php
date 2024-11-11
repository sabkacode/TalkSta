<?php
error_reporting(0);
session_start();

include 'dbcon.php';
include 'header.php';

$results_per_page = 10; // Number of results per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page number
$search = isset($_GET['search']) ? $_GET['search'] : '';

$start_from = ($page - 1) * $results_per_page;

if ($search) {
    $sql = "SELECT * FROM thread WHERE thread.threads_title LIKE '%$search%'
            OR thread.threads_desc LIKE '%$search%' 
            LIMIT $start_from, $results_per_page";
    
    $result = mysqli_query($conn, $sql);
    $total_results = mysqli_num_rows($result);

    // Fetch total number of results for pagination
    $sql_total = "SELECT COUNT(*) AS total FROM thread WHERE thread.threads_title LIKE '%$search%'
                  OR thread.threads_desc LIKE '%$search%'";
    $result_total = mysqli_query($conn, $sql_total);
    $row_total = mysqli_fetch_assoc($result_total);
    $total_pages = ceil($row_total['total'] / $results_per_page);
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Search-<?php echo htmlspecialchars($search); ?></title>
</head>

<body>
    <div class="container mt-3">
        <h2 class="py-3">Search results for: <em>"<?php echo htmlspecialchars($search); ?>"</em></h2>
        <div class="results">
            <?php
            if ($total_results > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $title = htmlspecialchars($row['threads_title']);
                    $desc = htmlspecialchars($row['threads_desc']);
                    $tid = $row['threads_id'];
                    $url = "https://dj.000.pe/talksta/thread.php?threadid=" . $tid;

                    echo '<div class="result">';
                    echo '<h4><a class="text-dark" href="' . $url . '">' . $title . '</a></h4>';
                    echo '<p>' . $desc . '</p>';
                    echo '</div>';
                }
            } else {
                echo '<p>No results found.</p>';
            }
            ?>
        </div>

        <div class="pagination"style="display:inline">
            <?php if ($page > 1): ?>
                <a href="?search=<?php echo urlencode($search); ?>&page=<?php echo $page - 1; ?>" class="btn btn-secondary">Previous</a>
            <?php endif; ?>

            <?php if ($page < $total_pages): ?>
                <a href="?search=<?php echo urlencode($search); ?>&page=<?php echo $page + 1; ?>" class="btn btn-primary">Next</a>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
    <br><BR><BR><BR>
</body>

</html>
