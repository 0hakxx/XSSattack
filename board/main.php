<?
  @include_once("./common.php");
  $db_conn = mysql_conn();
  $query = "select * from {$tb_name} order by idx desc limit 5";
  $result = $db_conn->query($query);
  $num = $result->num_rows;

?>
    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
		<h1 class="display-4">Main Page</h1>
    	<hr>
    </div>

      <div class="row">
        <div class="col-md-6">
          <table class="table">
            <thead class="thead">
            <tr>
              <th colspan="2" class="text-left">Recent Posts</th>
            </tr>
            </thead>
            <tbody>
            <?
            if($num != 0) {
              for ( $i=0; $i<$num; $i++ ) {
                $row = $result->fetch_assoc();
            ?>
            <tr>
              <td width="75%"><a href="index.php?page=view&idx=<?=$row["idx"]?>"><?=$row["title"]?></a></td>
              <td width="25%" class="text-center"><?=$row["regdate"]?></td>
            </tr>
            <?
              }
            } else {
            ?>
                  <tr>
                    <td colspan="2" class="text-center"><br>Posts does not exist.</td>
                  </tr>
            <?
            }
            ?>
            </tbody>
          </table>
          <hr>
        </div>
        <div class="col-md-6">
        <?
          if(empty($_SESSION["id"])) {
        ?>
          <table class="table">
            <thead class="thead">
            <tr>
              <th class="text-left">Login</th>
            </tr>
            </thead>
            <tbody>
            <tr>
            <td>
              <form class="needs-validation" action="index.php?page=login" method="POST" novalidate>
                <div class="mb-3">
                  <div class="input-group">
                    <input type="text" class="form-control" name="id" id="username" placeholder="ID" required>
                  </div>
                </div>
                <div class="mb-3">
                  <input type="password" class="form-control" name="password" placeholder="Password" required>
                  <div class="invalid-feedback">
                    (필수) 패스워드를 입력하세요.
                  </div>
                </div>
                <button class="btn btn-primary btn-sm btn-block" type="submit">LOGIN</button>
              </form>
            </td>
            </tr>
          </tbody>
          </table>
          <hr>
        <? } else { ?>
          <?
            $query = "select * from members where id='{$_SESSION["id"]}'";
            $result = $db_conn->query($query);
            $num = $result->num_rows;
            if($num != 0) {
              $row = $result->fetch_assoc();
          ?>
          <table class="table">
            <thead class="thead">
            <tr>
              <th class="text-left">User Info</th>
            </tr>
            </thead>
            <tbody>
            <tr>
            <td>
              <li>이름 : <?=$row["name"]?></li>
              <li>회사 : <?=$row["company"]?></li>
              <li>이메일 : <?=$row["email"]?></li>
              <br>
              <button class="btn btn-primary btn-sm btn-block" type="button" onclick="location.href='index.php?page=mypage'">회원정보 변경</button>
            </td>
            </tr>
          </tbody>
          </table>
          <hr>
          <? } ?>
        <? } ?>
        </div>
      </div>
    </div>
