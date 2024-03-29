<?php
session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <title>지원이의 산뜻한 페이지</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <noscript>
        <link rel="stylesheet" href="assets/css/noscript.css" />
    </noscript>

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

        <!-- Intro -->
        <div id="intro">
            <h1>지원이 최고야</h1>
            <p>보기싫으면 밑으로!</p>
            <ul class="actions">
                <li><a href="#header" class="button icon solid solo fa-arrow-down scrolly">계속</a></li>
            </ul>
        </div>

        <!-- Header -->
        <header id="header">
            <a href="/index.php" class="logo">페이지 제목</a>
        </header>

        <!-- Nav -->
        <nav id="nav">

            <ul class="links">
                <li class="active"><a href="/index.php">메인</a></li>
                <li><a href="/board/notification/list_nboard.php">공지사항</a></li>
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

            <!-- Featured Post -->
            <article class="post featured">
                <header class="major">
                    <h2><a href="#">제목<br />
                            이에요</a></h2>
                    <p>사이트 설명.</p>

                </header>
                <a href="#" class="image main"><img src="images/pic01.jpg" alt="" /></a>
            </article>

            <!-- Posts -->
            <section class="posts">
                <article>
                    <header>
                        <h2><a href="#">공지사항</a></h2>
                    </header>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">제목</th>
                                <th scope="col">작성자</th>
                                <th scope="col">등록일</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include './connect.php'; // 데이터베이스 연결 정보 포함
                            
                            // 최신 공지사항 5개를 가져오는 쿼리
                            $sql_n = 'SELECT * FROM n_board ORDER BY important DESC, created DESC LIMIT 5';
                            $result_n = mysqli_query($conn, $sql_n); ?>

                            <?php
                            while ($row_n = mysqli_fetch_array($result_n)) {
                                ?>
                                <tr>
                                    <td>
                                        <a href="n_readBoard.php?number=<?php echo $row_n['number']; ?>">
                                            <?php echo $row_n['title']; ?>
                                        </a>
                                    </td>
                                    <td>
                                        <?php echo $row_n['nickname']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row_n['created']; ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>

                    <a href="#" class="image fit"><img src="images/pic02.jpg" alt="" /></a>
                    <p>공지사항입니다.</p>
                    <ul class="actions special">
                        <li><a href="/board/notification/list_nboard.php" class="button">이동하기</a></li>
                    </ul>
                </article>
                <article>
                    <header>

                        <h2><a href="#">자유게시판</a></h2>
                    </header>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">제목</th>
                                <th scope="col">작성자</th>
                                <th scope="col">등록일</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include './connect.php'; // 데이터베이스 연결 정보 포함
                            
                            $sql_s = 'SELECT * FROM s_board ORDER BY created DESC LIMIT 5';
                            $result_s = mysqli_query($conn, $sql_s); ?>

                            <?php
                            while ($row_s = mysqli_fetch_array($result_s)) {
                                ?>
                                <tr>
                                    <td>
                                        <a href="board/standard/readBoard.php?number=<?php echo $row_s['number']; ?>">
                                            <?php echo $row_s['title']; ?>
                                        </a>
                                    </td>
                                    <td>
                                        <?php echo $row_s['nickname']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row_s['created']; ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <a href="#" class="image fit"><img src="images/pic03.jpg" alt="" /></a>
                    <p>자유게시판입니다.</p>
                    <ul class="actions special">
                        <li><a href="/board/standard/list_board.php" class="button">이동하기</a></li>
                    </ul>
                </article>
                <article>
                    <header>

                        <h2><a href="#">자료실</a></h2>
                    </header>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">제목</th>
                                <th scope="col">작성자</th>
                                <th scope="col">등록일</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include './connect.php'; // 데이터베이스 연결 정보 포함
                            
                            $sql_r = 'SELECT * FROM r_board ORDER BY created DESC LIMIT 5';
                            $result_r = mysqli_query($conn, $sql_r); ?>

                            <?php
                            while ($row_r = mysqli_fetch_array($result_r)) {
                                ?>
                                <tr>
                                    <td>
                                        <a href="n_readBoard.php?number=<?php echo $row_r['number']; ?>">
                                            <?php echo $row_r['title']; ?>
                                        </a>
                                    </td>
                                    <td>
                                        <?php echo $row_r['nickname']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row_r['created']; ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <a href="#" class="image fit"><img src="images/pic03.jpg" alt="" /></a>
                    <p>자료실입니다.</p>
                    <ul class="actions special">
                        <li><a href="/board/reference/list_rboard.php" class="button">이동하기</a></li>
                    </ul>
                </article>
                <article>
                    <header>

                        <h2><a href="#">Q&A</a></h2>
                    </header>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">제목</th>
                                <th scope="col">작성자</th>
                                <th scope="col">등록일</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include './connect.php'; // 데이터베이스 연결 정보 포함
                            
                            $sql_q = 'SELECT * FROM q_board ORDER BY created DESC LIMIT 5';
                            $result_q = mysqli_query($conn, $sql_q); ?>

                            <?php
                            while ($row_q = mysqli_fetch_array($result_q)) {
                                ?>
                                <tr>
                                    <td>
                                        <a href="n_readBoard.php?number=<?php echo $row_q['number']; ?>">
                                            <?php echo $row_q['title']; ?>
                                        </a>
                                    </td>
                                    <td>
                                        <?php echo $row_q['nickname']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row_q['created']; ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <a href="#" class="image fit"><img src="images/pic03.jpg" alt="" /></a>
                    <p>Q&A입니다.</p>
                    <ul class="actions special">
                        <li><a href="/board/QandA/list_qboard.php" class="button">이동하기</a></li>
                    </ul>
                </article>
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
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/jquery.scrollex.min.js"></script>
    <script src="assets/js/jquery.scrolly.min.js"></script>
    <script src="assets/js/browser.min.js"></script>
    <script src="assets/js/breakpoints.min.js"></script>
    <script src="assets/js/util.js"></script>
    <script src="assets/js/main.js"></script>

</body>

</html>