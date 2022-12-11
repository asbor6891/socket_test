<?php

header("Content-Type: text/plain;");
set_time_limit(0); 
ob_implicit_flush(); 

$address = "localhost"; 
$port = 1986; 

if (($sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) < 0) {
    echo "Ошибка создания сокета!";
} else {
    echo "Сокет успешно создан!\n";
}

if (($ret = socket_bind($sock, $address, $port)) < 0) {
    echo "Ошибка связи сокета с адресом и портом!";
} else {
    echo "Сокет успешно связан с адресом и портом!\n";
}

if (($ret = socket_listen($sock, 5)) < 0) {
    echo "Ошибка при попытке прослушивания сокета!";
} else {
    echo "Ждём подключение клиента...\n";
}
  
do {
    if (($msgsock = socket_accept($sock)) < 0) {
        echo "Ошибка при старте соединения с сокетом!";
    } else {
        echo "Сокет готов к приёму сообщений!\n";
    }

    $msg = "Добро пожаловать!\n"; 
    echo "Сообщение от сервера: $msg";

    socket_write($msgsock, $msg, strlen($msg)); 

    do {
        echo "Сообщение от клиента: ";

        if (false === ($buf = socket_read($msgsock, 1024))) {
            echo "Ошибка при чтении сообщения от клиента!";     
        } else {
            echo $buf . "\n";
        }
      
        if ($buf == "exit") {
            socket_close($msgsock);
            break 2;
        }

        if (!is_numeric($buf)) {
            echo "Сообщение от сервера: передано НЕ число!\n";
        } else {
            $buf = $buf * $buf;
            echo "Сообщение от сервера: ($buf)\n";
        }
        socket_write($msgsock, $buf, strlen($buf));
    } while (true);
} while (true);

if (isset($sock)) {
    socket_close($sock);
    echo "Сокет успешно закрыт!\n";
}