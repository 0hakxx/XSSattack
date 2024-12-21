<?
	include_once("./common.php");

	$db_conn = mysql_conn();
	$idx = $_GET["idx"];

	if(!is_numeric($idx)) {
		echo "<script>alert('입력 값이 잘못되었습니다.');history.back(-1);</script>";
		exit();
	}

	$query = "select * from {$tb_name} where idx={$idx}";
  
	$result = $db_conn->query($query);
	$num = $result->num_rows;
?>
    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
      <h1 class="display-4">Modify Page</h1>
      <hr>
    </div>
	<?
	if($num != 0) {
	  $row = $result->fetch_assoc();
	  $row["content"] = str_replace("<br>", "\r\n", $row["content"]);
	?>
    <div class="container">
		<form action="action.php" method="POST">
		  <div class="form-group">
			<label>Title</label>
			<input type="text" class="form-control" name="title" placeholder="Title Input" value="<?=$row["title"]?>">
		  </div>
		<div class="form-group">
			<label for="exampleInputPassword1">Contents</label>
			<textarea class="form-control" name="content" rows="5" placeholder="Contents Input"><?=$row["content"]?></textarea>
      	</div>
		<div class="text-right">
			<input type="hidden" name="idx" value="<?=$row["idx"]?>">
			<input type="hidden" name="mode" value="modify">
			<button type="submit" class="btn btn-outline-secondary">Modify</button>
			<button type="button" class="btn btn-outline-danger" onclick="history.back(-1);">Back</button>
		</div>
		</form>
    </div>
	<?
	} else {
	?>
		<script>alert("존재하지 않는 게시글 입니다.");history.back(-1);</script>
	<?
	}
	?>
<?
	$db_conn->close();
?>
