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



$sql = "SELECT * FROM r_board WHERE $category LIKE '%$search_con%' $orderBy";
$result = mysqli_query($conn, $sql);

?>

<!doctype html>
<html lang="ko">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>

    <title>검색 결과:
        <?php echo htmlspecialchars($search_con); ?>
    </title>
    <style>
        /* 색상 및 폰트 */
        body {
            font-family: 'Arial', sans-serif;
            color: #333;
        }

        /* 테이블 스타일링 */
        .table thead {
            background-color: #4CAF50;
            color: white;
        }

        .table tbody tr:hover {
            background-color: #f5f5f5;
        }

        /* 버튼 및 폼 요소 */
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        input[type="text"] {
            padding: 5px;
            margin: 5px;
        }

        @media (max-width: 768px) {
            body {
                font-size: 16px;
            }

            .table {
                font-size: 14px;
            }

            input[type="text"],
            button {
                padding: 12px;
                font-size: 16px;
            }

            .table tbody tr:hover {
                background-color: transparent;
                /* 모바일에서는 호버 효과를 제거 */
            }

            /* 네비게이션 및 기타 요소들을 위한 추가적인 스타일링 */
        }

        /* 아이콘 사용 */
        .sort-icon {
            font-size: 12px;
            margin-left: 5px;
        }

        .back-to-list {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .back-to-list:hover {
            background-color: #0056b3;
        }

        /* 검색 결과 섹션 스타일링 */
        .search-results {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .search-results h1 {
            margin-bottom: 20px;
        }

        @media screen and (max-width: 768px) {

            /* 컨테이너 스타일 조정 */
            .container {
                width: 100%;
                padding: 15px;
                margin-top: 10px;
            }

            /* 폰트 크기 조정 */
            h2,
            .table th,
            .table td {
                font-size: 14px;
            }

            /* 버튼 크기 조정 */
            button {
                padding: 10px;
                font-size: 14px;
            }

            /* 폼 요소 크기 조정 */
            input[type="text"],
            select {
                width: 100%;
                margin: 5px 0;
            }

            /* 테이블 스크롤 가능하게 설정 */
            .table-responsive {
                overflow-x: auto;
            }

            /* 네비게이션 및 기타 요소들을 위한 추가적인 스타일링 */
        }
    </style>
</head>

<body>
    <div class="container search-results">
        <h1 class="text-center">검색결과:
            <?php echo htmlspecialchars($search_con); ?>
        </h1>
        <div class="table-responsive">
            <div id="search_box">
                <form action="r_search_result.php" method="get">
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
                        $link = "r_readBoard.php?number=" . $row['number'];
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
</body>

</html>