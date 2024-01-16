<?php
include '../../connect.php';
$number = $_GET['number'];
// $sql = "select userid from q_comment where number= '$number'";
// $row = mysqli_fetch_array(mysqli_query($conn, $sql));

?>

<?php
//사용자 권한 확인
session_start();
$userid = $_SESSION['UserID'];

// $check_user = "select authority from users where id='$userid'";
// $rows = mysqli_fetch_array(mysqli_query($conn, $check_user));

?>


<!DOCTYPE html>
<html lang="ko">

<head>
</head>

<body>
    <?php

    if ($_SESSION['authority'] != "admin") {
        ?>
        <script>
            alert("접근 권한이 없습니다.");
            location.href = "./list_qboard.php";
        </script>
        <?php
        exit();
    }
    ?>
    <?php

    $sql = "delete from q_comment where number = '$number'";
    $row = mysqli_fetch_array(mysqli_query($conn, $sql));

    ?>
    <script>
        alert("댓글이 삭제되었습니다.");
        location.href = "list_qboard.php";
    </script>

</body>

</html>