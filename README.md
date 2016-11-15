# ChatRoom
A simple chatroom

## 运行注意事项

* 运行在服务器端，可以用IIS搭建，也可以用APPServ搭建

* 提前需要创建一个chat的mysql数据库、Messages的表 
包括：\

<pre><code>create table messages (
id int(7) not null auto_increment,
user varchar(255) not null,
msg text not null,
time int(9) not null,
PRIMARY KEY (id)
);</code></pre>

* 在php中将数据库的用户名和密码改为自己的即可
