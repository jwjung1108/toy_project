<?php
include '../../connect.php';
include '../point/ReadPoint.php';
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
        }.btn-sort {
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
                $number = $_GET['number']; /* bno함수에 title값을 받아와 넣음*/
                $board = mysqli_fetch_array(mysqli_query($conn, "select * from r_board where number ='" . $number . "'"));

                $check_table = (mysqli_query($conn, "select * from r_time where userid='" . $_SESSION['UserID'] . "' and boardnumber = '$number'"));
                $row = mysqli_fetch_array($check_table);

                $result = mysqli_num_rows($check_table) > 0;

                // 현재시간
                $current_time = time();

                // time table access 시간
                $db_access = mysqli_fetch_array(mysqli_query($conn, "select access from r_time where boardnumber=$number and userid='{$_SESSION['UserID']}'"));

                $fomater = "Y-m-d H:i:s";
                $view = $board['views'];

                if ($result) {
                    if ($current_time - strtotime($db_access['access']) > 3600) {
                        $view = $view + 1;
                        if (mysqli_query($conn, "update r_board set views = '" . $view . "' where number = '" . $number . "'")) {
                            $current_time = date($fomater, $current_time);
                            mysqli_query($conn, "update r_time set access = '$current_time' where boardnumber = $number and userid = '{$_SESSION['UserID']}'");
                        }
                    }
                } else {
                    $view = $view + 1;
                    $current_time = date($fomater, $current_time);
                    mysqli_query($conn, "insert into r_time(userid,boardnumber, access) values('{$_SESSION['UserID']}', $number, '$current_time')");
                    mysqli_query($conn, "update r_board set views = '" . $view . "' where number = '" . $number . "'");
                }
                ?>
                <!-- 글 불러오기 -->
                <div id="board_read">
                    <h2>
                        <?php echo $board['title']; ?>
                    </h2>
                    <div id="user_info">
                        <?php echo $board['title']; ?>
                        <?php echo $board['created']; ?> 조회:
                        <?php echo $view; ?> 추천:
                        <?php echo $board['likes']; ?>
                        <div id="bo_line"></div>
                    </div>
                    <div id="bo_content">
                        <?php echo nl2br($board['board']); ?>
                    </div>

                    <div id="image_container">
                        <?php
                        $imagePath = ''; // 이미지 파일이 아닌 경우 기본적으로 빈 문자열로 초기화
                        
                        // 이미지 파일 확장자 목록
                        $imageExtensions = array('jpg', 'jpeg', 'png', 'gif');

                        if (!empty($board['filename'])) {
                            $fileExtension = strtolower(pathinfo($board['filename'], PATHINFO_EXTENSION));

                            // 이미지 확장자인 경우 이미지 경로 설정
                            if (in_array($fileExtension, $imageExtensions)) {
                                $absoluteImagePath = $board['filepath'];

                                // 웹 서버 루트 디렉토리까지의 절대 경로
                                $webServerRoot = $_SERVER['DOCUMENT_ROOT'];

                                // 상대 경로 생성 (웹 서버 루트 디렉토리 제거)
                                $imagePath = str_replace($webServerRoot, '', $absoluteImagePath);
                            }
                        }

                        // 이미지를 표시할지 여부를 검사하여 이미지를 표시
                        if (!empty($imagePath)) {
                            echo '<img src="' . $imagePath . '" alt="첨부 이미지" id="image">';
                        }

                        ?>
                    </div>

                    <!-- 목록, 수정, 삭제 -->
                    <div id="bo_ser">

                        <a class="btn-sort" href="r_replaceBoard.php?number=<?php echo $board['number']; ?>">[수정]</a>
                        <a class="btn-sort" href="r_deleteBoard.php?number=<?php echo $board['number']; ?>">[삭제]</a>
                        <a class="btn-sort" href="r_boardLike.php?number=<?php echo $board['number']; ?>">[추천]</a>

                    </div>
                    <div>
                        <?php $download = isset($board['filename']) ? $board['filename'] : '';
                        if ($download === '') {
                            echo "다운로드 파일이 존재하지 않습니다.";
                        } else {
                            echo $board['filename'] . " "; ?>
                            <a href="../r_download.php?number=<?php echo $board['number']; ?>">[다운로드]</a>
                            <?php
                        }
                        ?>
                    </div>

                    <!-- 댓글 -->
                    <?php
                    $sql = "select * from r_comment where boardnumber = '$number'";
                    $result = mysqli_query($conn, $sql);
                    ?>
                    <div>
                        <h2>댓글</h2>
                        <table>
                            <thead>
                                <tr>
                                    <th scope="col">번호</th>
                                    <th scope="col">내용</th>
                                    <th scope="col">작성자</th>
                                    <th scope="col">등록일</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                while ($row = mysqli_fetch_array($result)) {
                                    ?>
                                    <tr>
                                        <th scope="row">
                                            <?php echo $i++; ?>
                                        </th>
                                        <td>
                                            <a>
                                                <?php echo $row['comment']; ?>
                                            </a>
                                        </td>
                                        <td>
                                            <?php echo $row['nickname']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['created']; ?>
                                        </td>
                                        <td>
                                            <a href="r_deleteComment.php?number=<?php echo $row['number'] ?>">
                                                <?php echo "삭제"; ?>
                                            </a>
                                        </td>
                                    </tr>
                                <?php }
                                ?>
                            </tbody>
                        </table>
                        <p></p>
                        <div>

                            <div>
                                <form class="box-form" action='r_writeCommentProcess.php?number=<?php echo $number ?>' method="POST">
                                    <textarea name="comment" style="resize: none;"></textarea>
                                    <input type="hidden" name="boardnumber" value="<?php echo $number; ?>">
                                    <input type="submit" value="작성">
                                </form>
                            </div>


                            <div>
                                <a href="/" class="btn-sort">목록으로 돌아가기</a>
                            </div>
                        </div>
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