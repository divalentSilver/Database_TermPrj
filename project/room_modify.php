<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);

$room_no = $_POST['room_no'];
$room_type = $_POST['room_type'];
$room_price = $_POST['room_price'];
$mgr_id = $_POST['mgr_id'];

/*******transaction*******/
mysqli_query($conn, "set autocommit = 0");	// autocommit 해제
mysqli_query($conn, "set transation isolation level serializable");	// isolation level 설정
mysqli_query($conn, "begin");	// begins a transation

$ret = mysqli_query($conn, "update room set room_type = '$room_type', room_price = '$room_price', mgr_id = '$mgr_id' where room_no = $room_no");

if(!$ret)
{
	// update room fail
	mysqli_query($conn, "rollback"); // 객실 정보 수정 query 수행 실패. 수행 전으로 rollback
    msg('Query Error : '.mysqli_error($conn));
}
else
{
	mysqli_query($conn, "commit"); // 객실 정보 수정 query 수행 성공. 수행 내역 commit
    s_msg ('성공적으로 수정 되었습니다');
    echo "<meta http-equiv='refresh' content='0;url=room.php'>";
}
/*******transaction*******/

?>
