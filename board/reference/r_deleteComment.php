<?php
include '../../connect.php';

session_start();
$userid = $_SESSION['UserID'];

if ($_SESSION['authority'] != "admin") {
    ?>
    <script>
        alert("접근 권한이 없습니다.");
        location.href = "./list_rboard.php";
    </script>
    <?php
    exit();
}

$number = $_GET['number'];

$sql = "DELETE FROM r_comment WHERE number = '$number'";
$result = mysqli_query($conn, $sql);

if ($result) {
    ?>
    <script>
        alert("댓글이 삭제되었습니다.");
        history.go(-1);
    </script>
    <?php
} else {
    ?>
    <script>
        alert("댓글 삭제에 실패하였습니다.");
        history.go(-1);
    </script>
    <?php
}
?>
