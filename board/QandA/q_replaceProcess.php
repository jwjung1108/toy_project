<?php
session_start();
$userid = isset($_SESSION['UserID']) ? $_SESSION['UserID'] : '';
include '../../connect.php';

$sql = "select id from users where id = (select userid from q_board where number = '{$_GET['$number']}')";
$result = mysqli_fetch_array(mysqli_query($conn, $sql));

if ($userid == '' || ($userid != $result['id'] && $_SESSION['authority'] != "admin")) {
    ?>
    <script>
        alert("지정된 사용자가 아닙니다.");
        location.href = "list_qboard.php";
    </script>
    <?php
    exit();
}

$sql = "update q_board set title ='{$_POST['title']}', board='{$_POST['board']}' where number = '{$_GET['number']}'";

$result = mysqli_query($conn, $sql);

if ($result === false) {
    echo "저장에 문제가 생겼습니다. 관리자에게 문의해주세요.";
} else {
    ?>
    <script>
        alert("게시글이 수정되었습니다.");
        location.href = "list_qboard.php";
    </script>
    <?php
}
?>