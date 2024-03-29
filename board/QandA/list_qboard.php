<?php
session_start();
include '../../connect.php';

$userid = isset($_SESSION['UserID']) ? $_SESSION['UserID'] : '';

$tierIcons = [
    'Bronze' => '/icon/bronze.png',
    'Silver' => '/icon/silver.png',
    'Gold' => '/icon/gold.png',
    'Platinum' => '/icon/platinum.png',
    'Master' => '/icon/master.png',
    'Default' => '', // 기본 아이콘 경로
];

// SQL 쿼리문 수정
$sql = "SELECT q_board.*, users.user_rank
        FROM q_board
        JOIN users ON q_board.userid = users.id";

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

        .box-form {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .btn-sort {
            text-decoration: none;
            padding: 4px 12px;
            margin: 5px;
            font-size: 12px;
            display: inline-block;
            position: relative;
            border: 1px solid rgba(0, 0, 0, 0.21);
            border-bottom: 4px solid rgba(0, 0, 0, 0.21);
            border-radius: 4px;
            text-shadow: 0 1px 0 rgba(0, 0, 0, 0.15);
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
                <li><a href="/board/reference/list_rboard.php">자료실</a></li>
                <li class="active"><a href="/board/QandA/list_qboard.php">Q&A</a></li>
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
                <h1>Q&A 게시판</h1>

                <!-- 검색 -->
                <div>
                    <form class="box-form" action="q_search_result.php" method="get">
                        <select style="width:20%" name="catgo">
                            <option value="title">제목</option>
                            <option value="nickname">글쓴이</option>
                            <option value="board">내용</option>
                        </select>
                        <input type="text" name="search" required="required" />
                        <button>검색</button>
                    </form>
                </div>
                <div>
                    <table>
                        <thead>
                            <tr>
                                <th scope="col">번호</th>
                                <th scope="col">제목</th>
                                <th scope="col">작성자</th>
                                <th scope="col">등록일</th>
                                <th scope="col">조회수</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $i = 1;
                            while ($row = mysqli_fetch_array($result)) {
                                // 비밀글인 경우, authority가 2인 사용자나 작성자만 볼 수 있도록 체크
                                $authorRank = $row['user_rank'];
                                $tierIconPath = isset($tierIcons[$authorRank]) ? $tierIcons[$authorRank] : $tierIcons['Default'];

                                // Determine color based on rank
                                switch ($authorRank) {
                                    case 'Bronze':
                                        $color = 'color: #cd7f32;'; // Bronze color (e.g., brown)
                                        break;
                                    case 'Silver':
                                        $color = 'color: #c0c0c0;'; // Silver color (e.g., silver)
                                        break;
                                    case 'Gold':
                                        $color = 'color: #ffd700;'; // Gold color (e.g., gold)
                                        break;
                                    case 'Platinum':
                                        $color = 'color: #ff4500;'; // Platinum color (e.g., orange)
                                        break;
                                    case 'Master':
                                        $color = 'color: #ff8c00;'; // Master color (e.g., orange)
                                        break;
                                    default:
                                        $color = 'color: black;'; // Default color (e.g., black)
                                        break;
                                }

                                ?>
                                <tr>
                                    <th scope="row">
                                        <?php echo $i++; ?>
                                    </th>
                                    <?php
                                    if ($row['isSecret'] == 1) {
                                        if ($row['userid'] != $userid && $row['authority'] != 'admin') {
                                            ?>
                                            <td>
                                                <?php echo "비밀글입니다."; ?>
                                            </td>
                                            <?php
                                        } else {
                                            ?>
                                            <td><a href="q_readBoard.php?number=<?php echo $row['number']; ?>">
                                                    <?php echo $row['title']; ?>
                                                </a>
                                            </td>
                                        <?php }
                                    } else {
                                        ?>
                                        <td><a href="q_readBoard.php?number=<?php echo $row['number']; ?>">
                                                <?php echo $row['title']; ?>
                                            </a>
                                        </td>
                                    <?php } ?>
                                    <td style="<?php echo $color; ?>">
                                        <img src="<?php echo $tierIconPath; ?>" alt="tier" class="tier-icon" />
                                        <?php echo $row['nickname']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['created']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['views']; ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div>
                    <a class="btn-sort" href="q_writeForm.php">작성</a>
                    <a class="btn-sort" href="/">목록으로 돌아가기</a>
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