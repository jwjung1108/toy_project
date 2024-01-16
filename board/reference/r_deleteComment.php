<?php
include '../../connect.php';
session_start();
$number = $_GET['number'];
$sql = "SELECT userid from r_comment where number= '$number'";
$row = mysqli_fetch_array(mysqli_query($conn, $sql));

?>

<?php
//사용자 권한 확인
$userid = $_SESSION['UserID'];
$check_user = $_SESSION['authority'];

?>


<!DOCTYPE html>
<html lang="ko">

<head>
</head>

<body>
    <?php
    if ($row['userid'] != $userid) {
        if ($check_user != 'admin') {
            ?>
            <script>
                alert("'접근 권한이 없습니다.';");
                location.href = "list_rboard.php";
            </script>
            <?php
            exit();
        }
        ?>
        <?php
    }
    $sql = "select visible from r_comment where number = '$number' and visible = 1";
    $row = mysqli_fetch_array(mysqli_query($conn, $sql));

    $result = mysqli_query($conn, $sql);

    if ($result) {
        ?>
        <script>
            alert("댓글이 삭제되었습니다.");
            location.href = "list_reference.php?=<?php ?>";
        </script>
        <?php
    } ?>




</body>

</html>