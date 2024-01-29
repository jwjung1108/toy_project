<?php
include '../../connect.php';

// 정렬 방식 설정
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'number'; // 기본값은 순번
$sortIcon = ($sort == 'number') ? '▲' : '▼';
$search_con = isset($_GET['search']) ? $_GET['search'] : '';
// 정렬 기준 설정
$orderBy = '';
switch ($sort) {
    case 'views':
        $orderBy = 'ORDER BY views';
        break;
    case 'likes':
        $orderBy = 'ORDER BY likes';
        break;
    default:
        $orderBy = 'ORDER BY number';
        break;
}

// SQL 쿼리문 수정
$search_con = isset($_GET['search']) ? $_GET['search'] : '';
$category = isset($_GET['catgo']) ? $_GET['catgo'] : '';



$sql = "SELECT * FROM s_board WHERE $category LIKE '%$search_con%' $orderBy";
$result = mysqli_query($conn, $sql);

?>

<!doctype html>
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
                <li ><a href="/board/standard/list_board.php">자유게시판</a></li>
                <li><a href="/board/reference/list_rboard.php">자료실</a></li>
                <li><a href="/board/QandA/list_qboard.php">Q&A</a></li>
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
                <div class="container search-results">
                    <h1 class="text-center">검색결과:
                        <?php echo htmlspecialchars($search_con); ?>
                    </h1>
                    <div class="table-responsive">
                        <div id="search_box">
                            <form action="s_search_result.php" method="get">
                                <select name="catgo">
                                    <option value="title">제목</option>
                                    <option value="nickname">글쓴이</option>
                                    <option value="board">내용</option>
                                </select>
                                <input type="text" name="search" required="required" />

                                <button>검색</button>
                            </form>
                        </div>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">번호</th>
                                    <th scope="col">제목</th>
                                    <th scope="col">작성자</th>
                                    <th scope="col">등록일</th>
                                    <th scope="col">조회수</th>
                                    <th scope="col">추천수</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                while ($row = mysqli_fetch_array($result)) {
                                    $link = "s_readBoard.php?number=" . $row['number'];
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $row['number']; ?>
                                        </td>
                                        <td><a href="<?php echo $link; ?>">
                                                <?php echo $row['title']; ?>
                                            </a>
                                        </td>
                                        <td>
                                            <?php echo $row['nickname']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['created']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['views']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['likes']; ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="text-center">
                    <a href='/' class="back-to-list">목록으로</a>
                </div>
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