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

$row = mysqli_fetch_array(mysqli_query($conn, "select * from r_board where number= '$number'"));
$title = $row['title'];
$board = $row['board'];

$check_authority = mysqli_fetch_array(mysqli_query($conn, "SELECT authority FROM users WHERE id='$userid'"));
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <title>지원이의 산뜻한 페이지</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="/assets/css/main.css" />
    <noscript>
        <link rel="stylesheet" href="/assets/css/noscript.css" />
    </noscript>

    <style>
        .tier-icon {
            width: 20px;
            /* 이미지의 크기 조절 */
            height: 20px;
            display: inline-block;
            margin-right: 5px;
            /* 티어 아이콘 간의 간격 조절 */
        }
    </style>
    <script>
        function goToLoginPage() {
            window.location.href = "/join/login.php";
        }
        function goToSignupPage() {
            window.location.href = "/join/signup.php";
        }
        function goTocommonBoardPage() {
            window.location.href = "/board/standard/list_board.php";
        }
        function goTonotificationBoardPage() {
            window.location.href = "/board/notification/list_nboard.php";
        }
        function goToQandABoardPage() {
            window.location.href = "/board/QandA/list_qboard.php";
        }
        function goToReferencePage() {
            window.location.href = "/board/reference/list_rboard.php";
        }
        function logout() {
            const data = confirm("로그아웃 하시겠습니까?");
            if (data) {
                location.href = "/join/logoutProcess.php";
            }
        }
        function goToadminPage() {
            window.location.href = "/adminPage/adminpage.php";
        }
        function goToMyPage() {
            window.location.href = "/MyPage/mypage.php";
        }
    </script>


</head>

<body class="is-preload">

    <!-- Wrapper -->
    <div id="wrapper" class="fade-in">


        <!-- Header -->
        <header id="header">
            <a href="/index.php" class="logo">페이지 제목</a>
        </header>

        <!-- Nav -->
        <nav id="nav">

        <ul class="links">
                <li><a href="/index.php">메인</a></li>
                <li><a href="/board/notification/list_nboard.php">공지사항</a></li>
                <li><a href="/board/standard/list_board.php">자유게시판</a></li>
                <li class="active"><a href="/board/reference/list_rboard.php">자료실</a></li>
                <li><a href="/board/QandA/list_qboard.php">Q&A</a></li>
            </ul>
            <ul class="links" style="flex-grow:0;">
                <?php if (isset($_SESSION['UserID'])) { ?>
                    <?php if ($_SESSION['authority'] == 'admin') { ?>
                        <li><a href="/adminPage/adminpage.php">관리자페이지</a></li>
                    <?php } else { ?>
                        <li><a href="/MyPage/mypage.php">마이페이지</a></li>
                    <?php } ?>
                    <li><a onclick="logout()">로그아웃</a></li>

                <?php } else { ?>
                    <li><a href="/join/login.php">로그인</a></li>
                    <li><a href="/join/signup.php">회원가입</a></li>
                <?php } ?>
            </ul>


        </nav>

        <!-- Main -->
        <div id="main">


            <!-- Posts -->
            <section class="post">
                <?php
                $check_user = "SELECT userid FROM r_board WHERE userid = '$userid' AND number = '$number'";
                $result = mysqli_fetch_array(mysqli_query($conn, $check_user));

                if ($userid != $result['userid']) {
                    if ($check_authority['authority'] != 2) {
                        ?>
                        <script>
                            alert("접근 권한이 없습니다.");
                            location.href = "list_rboard.php";
                        </script>
                        <?php
                        exit();
                    }
                    ?>
                    <form action='r_replaceProcess.php?number=<?php echo $number ?>' method="POST">
                        <p><input type="title" name="title" value=<?php echo $title ?>></p>
                        <p><textarea name="board" cols="50" rows="10"><?php echo $board ?></textarea></p>
                        <p><input type="submit" value="수정"></p>
                    </form>
                    <?php
                } else {
                    ?>
                    <form action='r_replaceProcess.php?number=<?php echo $number ?>' method="POST">
                        <p><input type="title" name="title" value=<?php echo $title ?>></p>
                        <p><textarea name="board" cols="50" rows="10"><?php echo $board ?></textarea></p>
                        <p><input type="submit" value="수정"></p>
                    </form>
                    <?php
                }
                ?>

            </section>


        </div>

        <!-- Footer -->
        <footer id="footer">
            <section class="split contact">
                <section class="alt">
                    <h3>무슨</h3>
                    <p>설명적는곳</p>
                </section>
                <section>
                    <h3>무슨</h3>
                    <p><a href="#">설명적는곳</a></p>
                </section>
                <section>
                    <h3>무슨</h3>
                    <p><a href="#">설명적는곳</a></p>
                </section>
            </section>
        </footer>

        <!-- Copyright -->
        <div id="copyright">
            <ul>
                <li>&copy; Untitled</li>
                <li>Design: <a href="https://html5up.net">HTML5 UP</a></li>
            </ul>
        </div>

    </div>

    <!-- Scripts -->
    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/jquery.scrollex.min.js"></script>
    <script src="/assets/js/jquery.scrolly.min.js"></script>
    <script src="/assets/js/browser.min.js"></script>
    <script src="/assets/js/breakpoints.min.js"></script>
    <script src="/assets/js/util.js"></script>
    <script src="/assets/js/main.js"></script>

</body>

</html>