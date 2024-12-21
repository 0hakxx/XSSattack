<?
  $db_conn = mysql_conn();
  
  if(!empty($_SESSION["id"])) {
    echo "<script>location.href='index.php';</script>";
    exit();
  }

  $id = $_POST["id"];
  $password = $_POST["password"];
  
  if(!empty($id) && !empty($password)) {
    $password = md5($password);
    $query = "select * from members where id='{$id}' and password='{$password}'";
    $result = $db_conn->query($query);
    $num = $result->num_rows;

    if($num != 0) {
      $row = $result->fetch_assoc();
      $_SESSION["id"] = $row["id"];
      $_SESSION["name"] = $row["name"];
      echo "<script>location.href='index.php';</script>";
    } else {
      echo "<script>alert('아이디 혹은 패스워드가 틀렸습니다.');location.href='index.php';</script>";
      exit();
    }
  }
?>