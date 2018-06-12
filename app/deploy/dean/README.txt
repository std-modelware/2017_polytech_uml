================= АСО ПМ, модуль ДЕКАНАТ =================

Инструкция по установке и запуску:

1. Установка php, mysql, apache.
Debian/Ubuntu: sudo apt-get install lamp-server^
Windows: скачать и установить WinLAMP.4.0.0.exe с сайта http://winlamp.sourceforge.net/?module=download
Во время установки нужно будет создать пароль для mysql.

2. В командной строке/терминале перейти в директорию 
путь_к_проекту/app/deploy/dean/src

3. В файле index.php в строке 22:
$database = new Database('localhost', 'core', 'root', 'password');
заменить password на пароль, созданный во время установки mysql

4. Запустить сервер командой 
php -S localhost:9999
Вместо 9999 можно указать любой другой порт

