<?php
include '../../connect.php';

session_start();

$userid = isset($_SESSION['UserID']) ? $_SESSION['UserID'] : '';
if ($userid == '') {
    ?>
    <script>
        alert("로그인을 해주세요");
        location.href = "../index.php";
    </script>
    <?php
    exit();
}


$number = $_GET['number'];

$row = mysqli_fetch_array(mysqli_query($conn, "select * from s_board where number= '$number'"));
$title = $row['title'];
$board = $row['board'];

$check_authority = mysqli_fetch_array(mysqli_query($conn, "SELECT authority FROM users WHERE id='$userid'"));
?>

<!DOCTYPE html>
<html lang="ko">

<head>
</head>

<body>
    <?php
    $check_user = "SELECT userid FROM s_board WHERE userid = '$userid' AND number = '$number'";
    $result = mysqli_fetch_array(mysqli_query($conn, $check_user));

    if ($userId != $result['userid']) {
        if ($check_authority['authority'] != 2) {
            ?>
            <script>
                alert("접근 권한이 없습니다.");
                location.href = "list_board.php";
            </script>
            <?php
            exit();
        }
        ?>
        <form action='replaceProcess.php?number=<?php echo $number ?>' method="POST">
            <p><input type="title" name="title" value=<?php echo $title ?>></p>
            <p><textarea name="board" cols="50" rows="10"><?php echo $board ?></textarea></p>
            <p><input type="submit" value="수정"></p>
        </form>
        <?php
    } else {
        ?>
        <form action='replaceProcess.php?number=<?php echo $number ?>' method="POST">
            <p><input type="title" name="title" value=<?php echo $title ?>></p>
            <p><textarea name="board" cols="50" rows="10"><?php echo $board ?></textarea></p>
            <p><input type="submit" value="수정"></p>
        </form>
        <?php
    }
    ?>


</body>

</html>