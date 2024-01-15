<?php
include '../connect.php';
$hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

$authority = 1; // 사용자 일반 권한 부여

$sql = "
    insert into users
    (id, password, nickname, email, created,  authority)
    values('{$_POST['id']}','{$hashedPassword}','{$_POST['nickname']}','{$_POST['email']}', NOW(), '{$authority}')";

if ($_POST['id'] == ' ') {
    ?>
    <script>
        alert("아이디를 다시 입력해 주세요");
        location.href = "../index.php";
    </script>
    <?php
} else {
    $result = mysqli_query($conn, $sql);

    if ($result === false) {
        ?>
        <script>
            alert("저장에 문제가 생겼습니다. 관리자에게 문의해주세요.");
            location.href = "../index.php";
        </script>
        <?php
    } else {
        // sendVerificationEmail($_POST['email'], $token);

        ?>
        <script>
            alert("회원가입이 완료되었습니다");
            location.href = "../index.php";
        </script>
        <?php
    }
}
?>