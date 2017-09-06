
<?php
session_start();

if(isset($_POST['submit']))
{
	include 'dbh.inc.php';
	$uid = mysqli_real_escape_string($conn, $_POST['uid']);
	$pwd = mysqli_real_escape_string($conn, $_POST['pwd']);
//Error handlers
//CHeck for empty fields
	if (empty($uid) || empty($pwd)) {
	header("Location: ../index.php?login=empty");
	exit();
}
else
{
$sql = "SELECT * FROM users WHERE user_uid='$uid' OR user_email = '$uid'";
$result = mysqli_query($conn, $sql);
$resultCheck = mysqli_num_rows($result);
if($resultCheck < 1)
{
	header("Location: ../index.php?login=error");
	exit();
}
else{
	if ($row = mysqli_fetch_assoc($result)){
		//De-hashing the password
		$hashedPwdCheck = password_verify($pwd, $row['user_pwd']);
		if($hashedPwdCheck == false){
		header("Location: ../index.php?login=error");
	exit();	
}
elseif($hashedPwdCheck == true){
	$_SESSION['u_id'] = $row['user_id'];
	$_SESSION['u_first'] = $row['u_first'];
	$_SESSION['u_last'] = $row['u_last'];
	$_SESSION['u_email'] = $row['u_email'];
	$_SESSION['u_uid'] = $row['u_uid'];
	header("location: ../index.php?login=success");
	exit();
}
}
}
}
}
	else{
	header("location: ../signup.php");
	exit();
	}
?>
