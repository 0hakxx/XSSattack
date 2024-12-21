<?
	@session_start();
	header("Content-Type: text/html; charset=UTF-8");
	include("./common.php");

	$mode = $_REQUEST["mode"];
	$db_conn = mysql_conn();
	$id = $db_conn->real_escape_string($_SESSION["id"]);

	if(empty($id)) {
		echo "<script>alert('올바른 접근이 아닙니다.');history.back(-1);</script>";
		exit();
	}
	
	if($mode == "write") {
		$title = $db_conn->real_escape_string($_POST["title"]);
		$writer = $db_conn->real_escape_string($_SESSION["name"]);
		$content = $db_conn->real_escape_string($_POST["content"]);

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

		if(empty($idx) || empty($title) || empty($content)) {
			echo "<script>alert('빈칸이 존재합니다.');history.back(-1);</script>";
			exit();
		}

		if(!is_numeric($idx)) {
			echo "<script>alert('입력 값이 잘못되었습니다.');history.back(-1);</script>";
			exit();
		}

		$query = "select * from {$tb_name} where idx={$idx} and id='{$id}'";
		$result = $db_conn->query($query);
		$num = $result->num_rows;

		if($num == 0) {
			echo "<script>alert('올바른 접근이 아닙니다.');history.back(-1);</script>";
			exit();
		}

		$content = str_replace("\\r\\n", "<br>", $content);
		
		$query = "update {$tb_name} set title='{$title}', content='{$content}', regdate=now() where idx={$idx}";
		$db_conn->query($query);
	} else if($mode == "delete") {
		$idx = $_GET["idx"];

		if(!is_numeric($idx)) {
			echo "<script>alert('입력 값이 잘못되었습니다.');history.back(-1);</script>";
			exit();
		}
		
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

	echo "<script>location.href='index.php?page=board';</script>";
	$db_conn->close();
?>