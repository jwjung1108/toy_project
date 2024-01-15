<?php
include '../../connect.php';
?>

<?php
//사용자 권한 확인
session_start();
$userid = $_SESSION['UserID'];

if($_SESSION['authority'] != 'admin'){
    ?>
    <script>
        alert("지정된 사용자가 아닙니다.");
        location.href = "./list_nboard.php";
    </script>
    <?php
    exit();
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
</head>
<body>
    <?php
            $sql = "select authority from users where id='$userid'";
            $row = mysqli_fetch_array(mysqli_query($conn, $sql));
            if ($row['authority'] == 2) {
                ?><a href="n_writeForm.php" class="btn btn-primary">작성</a>
                <?php
            }
            ?>
    <?php

    
        $number = $_GET['number'];
        $row = mysqli_fetch_array(mysqli_query($conn,"select * from n_board where number= '$number'"));
        $title = $row['title'];
        $board = $row['board'];
    ?>

 
  <form action='n_replaceProcess.php?number=<?php echo $number?>' method="POST">
    <p><input type="title" name="title" value= <?php echo $title?>></p>
    <p><textarea name="board" cols="50" rows="10"><?php echo $board?></textarea></p>
    <p><input type="submit" value = "수정"></p>
  </form>
</body>
</html>