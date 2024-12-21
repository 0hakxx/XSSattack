<?
	header("Content-Type: text/html; charset=UTF-8");
	$id = $_GET["id"];
	if(preg_match("/script/i", $id)) {
		print("<script>alert(\"SCRIPT 태그 입력 없이 공격에 성공하세요.\");history.back(-1);</script>");
		exit;
	}
?>
<!DOCTYPE html>
<html lang="ko">
    <head>
    <title>Crehacktive Training System</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script>
        function permissionCheck() {
            if("" == "<?=$_GET["id"]?>") {
                document.write("비인가자입니다.");
            } else if("admin" != "<?=$_GET["id"]?>") {
                document.write("당신은 관리자가 아닙니다~");
            } else {
                document.write("당신은 관리자입니다.");
            }
            
        }
    </script>
    </head>
    <body>
    <form action="example5.php" method="GET">
    <input type="text" name="id">
    <input type="submit" value="Send">
    </form>
    <hr>
    result : <script>permissionCheck();</script>
    </body>
</html>