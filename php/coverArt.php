<?php




$db = mysqli_connect('localhost', 'root', '', 'demo');
    $query = "SELECT albumCover FROM music WHERE path='$s'";
    $results = mysqli_query($db, $query);
    if (mysqli_num_rows($results) == 1) {
        while($row = mysqli_fetch_assoc($results)) {
            echo '<div class="box"><img src=' . $row["albumCover"] . ' alt=Img width=70 height=70 ></div>';
        }
    }
    mysqli_close($db);


?>