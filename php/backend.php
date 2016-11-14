<?php

error_reporting(0);//屏蔽变量未定义的警告

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "12345678";
$dbname = "chat";
$store_num = 10;
$display_num = 10;

error_reporting(E_ALL);

header("Content-type: text/xml");
header("Cache-Control: no-cache");

/*$dbconn = mysql_connect($dbhost,$dbuser,$dbpass);//将来可能被废弃,mysql*/

/*if(! $dbconn )
{
  die('Could not connect: ' .mysql_error());
}*/
/*mysql_select_db($dbname,$dbconn);//mysql中*/

$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);//mysqli,mysql的扩展库，mysqli是面向对象，也可以面向过程
if(mysqli_connect_errno($dbconn))
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

if( @$_POST["action"] == 'postmsg'){//@作用：阻止警告输出
	$name=$_POST["name"];//输出的是字符串
    $msg=$_POST["message"];
    //sql中
/*	mysql_query("INSERT INTO messages (user,msg,time) 
	             VALUES ('$name','$message',".time().")",$dbconn);

	mysql_query("DELETE FROM messages WHERE id <= ".
				(mysql_insert_id($dbconn)-$store_num),$dbconn);*/

	mysqli_query($dbconn,"INSERT INTO messages (user,msg,time) 
	             VALUES ('$name','$msg',".time().")");

	mysqli_query($dbconn,"DELETE FROM messages WHERE id <= ".
				(mysqli_insert_id($dbconn)-$store_num));
}


$time=@$_POST["time"];
/*$messages = mysql_query("SELECT user,msg
						 FROM messages
						 WHERE time>$time
						 ORDER BY id ASC
						 LIMIT $display_num",$dbconn);*/
$messages = mysqli_query($dbconn,"SELECT user,msg
						 FROM messages
						 WHERE time>$time
						 ORDER BY id ASC
						 LIMIT $display_num");
/*echo $messages;*/
if(mysqli_num_rows($messages)==0) $status_code = 2;
else $status_code = 1;


echo "<?xml version=\"1.0\"?>\n";
echo "<response>\n";
echo "\t<status>$status_code</status>\n";
echo "\t<time>".time()."</time>\n";
if($status_code == 1){
	while($message = mysqli_fetch_array($messages)){
		$message['msg'] = htmlspecialchars(stripslashes($message['msg']));
		echo "\t<message>\n";
		echo "\t\t<author>$message[user]</author>\n";
		echo "\t\t<msg>$message[msg]</msg>\n";
		echo "\t</message>\n";
	}
}
echo "</response>";
?>