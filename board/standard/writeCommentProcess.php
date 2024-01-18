<?php
include '../../connect.php';
include '../point/WriteCoPoint.php';

$number = $_GET['number'];
$sql = "
    insert into s_comment
    (userid, boardnumber, text, created)
    values('$userid','$number','{$_POST['text']}', NOW()
    )";

$result = mysqli_query($conn, $sql);

if ($result === false) {
    echo "저장에 문제가 생겼습니다. 관리자에게 문의해주세요.";
} else {
?>
    <script>
        alert("댓글이 작성되었습니다.");
        history.go(-1);
    </script>
<?php
}
?>