<?
	@session_start();
	header("Content-Type: text/html; charset=UTF-8");
	include("./common.php");
<?php
// 세션 시작
@session_start();
// 콘텐츠 타입을 UTF-8 인코딩의 HTML로 설정
header("Content-Type: text/html; charset=UTF-8");
// common.php 파일 포함 (데이터베이스 연결 등의 공통 기능 포함)
include("./common.php");

	$mode = $_REQUEST["mode"];
	$db_conn = mysql_conn();
	$id = $db_conn->real_escape_string($_SESSION["id"]);
// GET 또는 POST로 전달된 'mode' 파라미터 값을 가져옴
$mode = $_REQUEST["mode"];
// 데이터베이스 연결
$db_conn = mysql_conn();
// 세션에서 사용자 ID를 가져와 SQL 인젝션 방지를 위해 이스케이프 처리
$id = $db_conn->real_escape_string($_SESSION["id"]);

	if(empty($id)) {
		echo "<script>alert('올바른 접근이 아닙니다.');history.back(-1);</script>";
		exit();
	}
	
	if($mode == "write") {
		$title = $db_conn->real_escape_string($_POST["title"]);
		$writer = $db_conn->real_escape_string($_SESSION["name"]);
		$content = $db_conn->real_escape_string($_POST["content"]);
// 사용자 ID가 없으면 (로그인하지 않은 상태) 오류 메시지 출력 후 이전 페이지로 이동
if(empty($id)) {
    echo "<script>alert('올바른 접근이 아닙니다.');history.back(-1);</script>";
    exit();
}

// 모드에 따라 다른 동작 수행
if($mode == "write") {
    // 글쓰기 모드
    // POST로 전달된 제목, 작성자(세션에서), 내용을 가져와 이스케이프 처리
    $title = $db_conn->real_escape_string($_POST["title"]);
    $writer = $db_conn->real_escape_string($_SESSION["name"]);
    $content = $db_conn->real_escape_string($_POST["content"]);

		if(empty($title) || empty($content)) {
			echo "<script>alert('빈칸이 존재합니다.');history.back(-1);</script>";
			exit();
		}
    // 제목이나 내용이 비어있으면 오류 메시지 출력 후 이전 페이지로 이동
    if(empty($title) || empty($content)) {
        echo "<script>alert('빈칸이 존재합니다.');history.back(-1);</script>";
        exit();
    }

		$content = str_replace("\\r\\n", "<br>", $content);
		
		$query = "insert into {$tb_name}(title, id, writer, content, regdate) values('{$title}', '{$id}', '{$writer}', '{$content}', now())";
		$db_conn->query($query);
	} else if($mode == "modify") {
		$idx = $_POST["idx"];
		$title = $db_conn->real_escape_string($_POST["title"]);
		$content = $db_conn->real_escape_string($_POST["content"]);
    // 줄바꿈 문자를 HTML <br> 태그로 변환
    $content = str_replace("\\r\\n", "<br>", $content);

    // 데이터베이스에 새 글 삽입
    $query = "insert into {$tb_name}(title, id, writer, content, regdate) values('{$title}', '{$id}', '{$writer}', '{$content}', now())";
    $db_conn->query($query);

} else if($mode == "modify") {
    // 글 수정 모드
    // POST로 전달된 글 번호, 제목, 내용을 가져옴
    $idx = $_POST["idx"];
    $title = $db_conn->real_escape_string($_POST["title"]);
    $content = $db_conn->real_escape_string($_POST["content"]);

		if(empty($idx) || empty($title) || empty($content)) {
			echo "<script>alert('빈칸이 존재합니다.');history.back(-1);</script>";
			exit();
		}
    // 글 번호, 제목, 내용 중 하나라도 비어있으면 오류 메시지 출력 후 이전 페이지로 이동
    if(empty($idx) || empty($title) || empty($content)) {
        echo "<script>alert('빈칸이 존재합니다.');history.back(-1);</script>";
        exit();
    }

		if(!is_numeric($idx)) {
			echo "<script>alert('입력 값이 잘못되었습니다.');history.back(-1);</script>";
			exit();
		}
    // 글 번호가 숫자가 아니면 오류 메시지 출력 후 이전 페이지로 이동
    if(!is_numeric($idx)) {
        echo "<script>alert('입력 값이 잘못되었습니다.');history.back(-1);</script>";
        exit();
    }

		$query = "select * from {$tb_name} where idx={$idx} and id='{$id}'";
		$result = $db_conn->query($query);
		$num = $result->num_rows;
    // 해당 글이 현재 로그인한 사용자의 것인지 확인
    $query = "select * from {$tb_name} where idx={$idx} and id='{$id}'";
    $result = $db_conn->query($query);
    $num = $result->num_rows;

		if($num == 0) {
			echo "<script>alert('올바른 접근이 아닙니다.');history.back(-1);</script>";
			exit();
		}
    // 해당하는 글이 없으면 오류 메시지 출력 후 이전 페이지로 이동
    if($num == 0) {
        echo "<script>alert('올바른 접근이 아닙니다.');history.back(-1);</script>";
        exit();
    }

		$content = str_replace("\\r\\n", "<br>", $content);
		
		$query = "update {$tb_name} set title='{$title}', content='{$content}', regdate=now() where idx={$idx}";
		$db_conn->query($query);
	} else if($mode == "delete") {
		$idx = $_GET["idx"];
    // 줄바꿈 문자를 HTML <br> 태그로 변환
    $content = str_replace("\\r\\n", "<br>", $content);

    // 데이터베이스에서 해당 글 업데이트
    $query = "update {$tb_name} set title='{$title}', content='{$content}', regdate=now() where idx={$idx}";
    $db_conn->query($query);
} else if($mode == "delete") {
    // 글 삭제 모드
    // GET으로 전달된 글 번호를 가져옴
    $idx = $_GET["idx"];

		if(!is_numeric($idx)) {
			echo "<script>alert('입력 값이 잘못되었습니다.');history.back(-1);</script>";
			exit();
		}
		
		$query = "select * from {$tb_name} where idx={$idx} and id='{$id}'";
		$result = $db_conn->query($query);
		$num = $result->num_rows;
    // 글 번호가 숫자가 아니면 오류 메시지 출력 후 이전 페이지로 이동
    if(!is_numeric($idx)) {
        echo "<script>alert('입력 값이 잘못되었습니다.');history.back(-1);</script>";
        exit();
    }

    // 해당 글이 현재 로그인한 사용자의 것인지 확인
    $query = "select * from {$tb_name} where idx={$idx} and id='{$id}'";
    $result = $db_conn->query($query);
    $num = $result->num_rows;

		if($num == 0) {
			echo "<script>alert('올바른 접근이 아닙니다.');history.back(-1);</script>";
			exit();
		}
		
		$query = "delete from {$tb_name} where idx={$idx}";
		$db_conn->query($query);
	}
    // 해당하는 글이 없으면 오류 메시지 출력 후 이전 페이지로 이동
    if($num == 0) {
        echo "<script>alert('올바른 접근이 아닙니다.');history.back(-1);</script>";
        exit();
    }

    // 데이터베이스에서 해당 글 삭제
    $query = "delete from {$tb_name} where idx={$idx}";
    $db_conn->query($query);
}

	echo "<script>location.href='index.php?page=board';</script>";
	$db_conn->close();
// 모든 작업이 완료되면 게시판 페이지로 리다이렉트
echo "<script>location.href='index.php?page=board';</script>";
// 데이터베이스 연결 종료
$db_conn->close();
?>
