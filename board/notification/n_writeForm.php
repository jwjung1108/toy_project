<?php
include '../../connect.php';
session_start();
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
                <li class="active"><a href="/board/notification/list_nboard.php">공지사항</a></li>
                <li><a href="/board/standard/list_board.php">자유게시판</a></li>
                <li><a href="/board/reference/list_rboard.php">자료실</a></li>
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
                <form action="n_saveBoard.php" method="POST" enctype="multipart/form-data">
                    <h2 style="display: inline-block;">글쓰기</h2>
                    <a type="button" style="display: inline-block; float: right;" onclick="goBack()">X</a>
                    <p><input type="text" name="title" placeholder="제목 (예: 공지사항)"></p>
                    <p><textarea name="board" placeholder="본문 (경고메세지)" rows="8" style="resize: none;"></textarea></p>
                    <p>중요 공지사항<input type="checkbox" name="important" value="reference" style="float:right; opacity:1; appearance: auto;"></ㅈp>
                    <p>관련 파일 첨부 (옵션): <input type="file" name="file"></p>
                    <p><input type="submit" value="작성"></p>
                    
                </form>

                <script>
                    function goBack() {
                        window.history.back();
                    }
                </script>
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