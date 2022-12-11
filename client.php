<?php

header("Content-Type: text/plain;");
set_time_limit(0);
ob_implicit_flush();

$address = "localhost";
$port = 1986;

if (($socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) < 0) {
    echo "Ошибка создания сокета!";
} else {
    echo "Сокет успешно создан!\n";
}

$result = socket_connect($socket, $address, $port);
  
if ($result === false) {
    echo "Ошибка при подключении к сокету!";
} else {
    echo "Подключение к сокету прошло успешно!\n";
}

$out = socket_read($socket, 1024); 
echo "Сообщение от сервера: $out\n";

$msg = "7";
echo "Сообщение серверу: $msg\n";

socket_write($socket, $msg, strlen($msg));

$out = socket_read($socket, 1024); 
echo "Сообщение от сервера: $out\n"; 

$msg = "exit"; 
echo "Сообщение серверу: $msg\n";

socket_write($socket, $msg, strlen($msg));

echo "Соединение завершено!\n";

if (isset($socket)) {
    socket_close($socket);
    echo "Сокет успешно закрыт!";
}