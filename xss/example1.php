<!DOCTYPE html>
<html lang="ko">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 위 3개의 메타 태그는 *반드시* head 태그의 처음에 와야합니다; 어떤 다른 콘텐츠들은 반드시 이 태그들 *다음에* 와야 합니다 -->
    <title>CREHACKTIVE Search Engine</title>

    <!-- 부트스트랩 -->
    <link href="./css/bootstrap.min.css" rel="stylesheet">

    <!-- IE8 에서 HTML5 요소와 미디어 쿼리를 위한 HTML5 shim 와 Respond.js -->
    <!-- WARNING: Respond.js 는 당신이 file:// 을 통해 페이지를 볼 때는 동작하지 않습니다. -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link href="https://fonts.googleapis.com/css?family=Nanum+Gothic&display=swap&subset=korean" rel="stylesheet">
    <style>
        body { font-family: 'Nanum Gothic', sans-serif; }
    </style>
  </head>
  <body>
    <div class="container">
        <div class="page-header">
            <h1>CREHACKTIVE Search Engine <small>Example 1 : DOM-Based XSS</small></h1>
        </div>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <form method="GET">
                    <div class="input-group">
                        <input type="text" class="form-control" name="keyword" placeholder="Search for...">
                        <span class="input-group-btn">
                        <button class="btn btn-success" type="submit">Search</button>
                        </span>
                    </div>
                </form>
                <br>
                <span id="searchResult1"></span>
                <hr>
                <span id="searchResult2"></span>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
    <script>
        function searchKeywordPrint(keyword) {
            var result1 = "<div class=\"panel panel-default\"><div class=\"panel-body\">\"" + keyword + "\"에 대한 검색 결과 입니다.</div></div>";
            document.getElementById('searchResult1').innerHTML = result1;
            var result2 = "<div class=\"alert alert-warning alert-dismissible\" role=\"alert\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button><strong>Warning!</strong> 검색 결과가 존재하지 않습니다.</div>";
            document.getElementById('searchResult2').innerHTML = result2;
        }
        var keyword = (new URLSearchParams(window.location.search)).get('keyword');
        if(keyword) {
            searchKeywordPrint(keyword);
        }
    </script>
    <!-- jQuery (부트스트랩의 자바스크립트 플러그인을 위해 필요합니다) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- 모든 컴파일된 플러그인을 포함합니다 (아래), 원하지 않는다면 필요한 각각의 파일을 포함하세요 -->
    <script src="./js/bootstrap.min.js"></script>
  </body>
</html>