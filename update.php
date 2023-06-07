<?php
if (isset($_POST['point']) && isset($_POST['status'])) {
    // Connect to the database
    $db = pg_connect("host=localhost port=5432 dbname=db_coord user=postgres password=postgres");

    if (!$db) {
        die('Connection failed.');
    }

    // Prepare and execute the update query
    $point = $_POST['point'];
    $status = $_POST['status'];
    if($status == 'plot'){
        $status = 'skip';
    } elseif ($status == 'skip'){
        $status = 'belum';
    } else{
        $status = 'plot';
    }

    $sql = "UPDATE coord
            SET status = '{$status}'
            WHERE point = '{$point}';";


    $result = pg_query($db, $sql);
    if (!$result) {
        die('Update query failed.');
    }

    // Check the result
    if (pg_affected_rows($result) > 0) {
        // echo 'Update successful.';
    } else {
        // echo 'No rows were affected.';
    }

    // Close the database connection
    pg_close($db);
    
    header("Location: index.php?point={$point}");

}
?>
