<?php
include '../../connect.php';

session_start();
$userid = $_SESSION['UserID'];

$number = $_GET['number'];

$sql = "select userid from r_comment where number = '$number'";
$result = mysqli_fetch_array(mysqli_query($conn, $sql));

if ($result['userid'] != $userid) {
    if ($_SESSION['authority'] != 'admin') {
        ?>
        <script>
            alert("접근 권한이 없습니다.");
            history.go(-1);
        </script>
        <?php
        exit();
    }
}

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