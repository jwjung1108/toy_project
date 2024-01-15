<?php
include '../../connect.php';
session_start();
?>

<?php
// 사용자 권한 확인
$userid = isset($_SESSION['UserID']) ? $_SESSION['UserID'] : '';

// $sql = "SELECT authority FROM users WHERE id='$userid'";
// $row = mysqli_fetch_array(mysqli_query($conn, $sql));

?>

<!DOCTYPE html>
<html lang="ko">

<head>
</head>

<body>
    <?php
    $number = $_GET['number'];

    $check_comment = mysqli_query($conn, "select * from q_comment where boardnumber='$number'");
    $result = mysqli_num_rows($check_comment) > 0;

    if ($result) {
        ?>
        <script>
            alert("댓글이 존재하므로 삭제가 불가능합니다.");
            location.href = "./list_qboard.php";
        </script>
        <?php
        exit();
    }

    $check_user = "SELECT userid FROM q_board WHERE userid = '$userid' AND number = '$number'";
    $result = mysqli_fetch_array(mysqli_query($conn, $check_user));

    if ($userid != $result['userid']) {
        if ($_SESSION['authority'] != "admin") {
            ?>
            <script>
                alert("접근 권한이 없습니다.");
                location.href = "./list_qboard.php";
            </script>
            <?php
            exit();
        }


        $sql = "delete from q_board WHERE number = '$number'";
        mysqli_query($conn, $sql);
        ?>
        <script>
            alert("게시글이 삭제되었습니다.");
            location.href = "list_qboard.php";
        </script>
        <?php
        ?>
        <?php
    } else {
        $sql = "delete from q_board WHERE number = '$number'";
        mysqli_query($conn, $sql);
        ?>
        <script>
            alert("게시글이 삭제되었습니다.");
            location.href = "list_qboard.php";
        </script>
        <?php
    }
    ?>
</body>

</html>