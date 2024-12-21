<?
  @include_once("./common.php");
  
  $db_conn = mysql_conn();
  $page = $_SERVER['REQUEST_URI'];

  # Search Logic
  $search_type = $_GET["search_type"];
  $keyword = $db_conn->real_escape_string($_GET["keyword"]);

  if(empty($search_type) && empty($keyword)) {
    $query = "select * from {$tb_name}";
  } else {
    if($search_type == "all") {
      $query = "select * from {$tb_name} where title like '%{$keyword}%' or writer like '%{$keyword}%' or content like '%{$keyword}%'";
    } else {
      $type_arr = array("title"=>"title", "writer"=>"writer", "content"=>"content");

      if($type_arr[$search_type]) {
        $query = "select * from {$tb_name} where {$type_arr[$search_type]} like '%{$keyword}%'";
      } else {
        $query = "select * from {$tb_name} where title like '%{$keyword}%' or writer like '%{$keyword}%' or content like '%{$keyword}%'";
      }
      
    }
  }

  $query .= " order by idx desc";

  $result = $db_conn->query($query);
  $num = $result->num_rows;
  $keyword = str_replace("<", "&lt;", $keyword);
  $keyword = str_replace(">", "&gt;", $keyword);
  $keyword = str_replace("\\", "", $keyword);
?>
    <div class="container">
    <? if(!empty($_SESSION["id"])) { ?>
		<div class="text-right">
			<p><button type="button" class="btn btn-outline-secondary" onclick="location.href='index.php?page=write'">Write</button><p>
    </div>
    <? } else { ?>
      <p>&nbsp;</p>
    <? } ?>
		<table class="table">
		  <thead class="thead-dark">
			<tr>
			  <th width="10%" scope="col" class="text-center">No</th>
			  <th width="50%" scope="col" class="text-center">Title</th>
			  <th width="20%" scope="col" class="text-center">Write</th>
			  <th width="20%" scope="col" class="text-center">Date</th>
			</tr>
		  </thead>
		  <tbody>
			<?
			if($num != 0) {
				for ( $i=0; $i<$num; $i++ ) {
				  $row = $result->fetch_assoc();
			?>
			<tr>
			  <th scope="row" class="text-center"><?=$row["idx"]?></th>
        <td><a href="index.php?page=view&idx=<?=$row["idx"]?>"><?=$row["title"]?></a></td>
			  <td class="text-center"><?=$row["writer"]?></td>
			  <td class="text-center"><?=$row["regdate"]?></td>
			</tr>
			<?
				}
			} else {
			?>
            <tr>
              <td colspan="4" class="text-center">Posts does not exist.</td>
            </tr>
			<?
			}
			?>
		  </tbody>
    </table>
    <form action="<?=$page?>" method="GET">
    <div class="input-group mb-3">
        <div class="col-auto my-1">
          <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="search_type">
          <script>
              var types = ["all","title","writer","content"];
              var type = (new URLSearchParams(window.location.search)).get('search_type');
              if(type) {
                  document.write('<option value="'+type+'" selected>'+type+'</option>');
              }
              for(var i=0;i<types.length;i++) {
                  if(types[i] === type) {
                      continue;
                  }
                  document.write('<option value="'+types[i]+'">'+types[i]+'</option>');
              }
          </script>
          </select>
        </div>
				<input type="text" class="form-control" placeholder="Keyword Input" name="keyword" value="<?=$keyword?>">
        <input type="hidden" name="page" value="board">
				<div class="input-group-append">
				<button class="btn btn-outline-secondary" type="submit">Search</button>
        </div>
    </div>
    </form>

    </div>
<?
	$db_conn->close();
?>
