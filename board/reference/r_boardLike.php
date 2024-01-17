<?php
session_start();

include '../../connect.php';


// 연결 성공 시, 여기에 작업을 수행할 수 있습니다.

// 게시물 ID 가져오기
$post_id = $_GET['number'];
$userid = $_SESSION['UserID'];

// Prepared Statements를 사용하여 SQL Injection 방지
// 게시글에 대한 사용자별 추천 여부 확인
$check_user = (mysqli_query($conn, "select * from r_post_likes where userid= '$userid' and post_id = '$post_id'"));
$row = mysqli_fetch_array($check_user);

$isLiked = mysqli_num_rows($check_user) > 0;

if (!$isLiked) {
    // 게시글에 대한 추천 기록 삽입
    $sql = "insert into r_post_likes(post_id, userid,created) values('$post_id','$userid',NOW())";
    mysqli_query($conn, $sql);

    // 게시글 추천 수 업데이트
    $sql = "update r_board set likes = likes + 1 where number = '$post_id'";
    mysqli_query($conn, $sql);

    // 추천 받은 게시물 사용자 포인트 증가
    $sql = "update users set point = point + 13 where id = (select userid from r_board where number = '$post_id')";
    mysqli_query($conn, $sql)

        // 추천 완료 메시지 출력
        ?>
    <script>
        alert("추천되었습니다.");
        location.href = "r_readBoard.php?number=<?php echo $post_id ?>";
    </script>
    <?php
} else {
    // 이미 추천한 경우 메시지 출력
    ?>
    <script>
        alert("이미 추천되었습니다.");
        location.href = "r_readBoard.php?number=<?php echo $post_id ?>";
    </script>
    <?php
}

// 데이터베이스 연결 종료
?>