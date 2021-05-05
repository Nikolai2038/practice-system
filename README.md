<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<hr/>

<p align="center"><h3>АИС "Прохождение производственной практики"</h3></p>

<hr/>

<p align="center"><h4>Технологии</h4></p>

<hr/>

- Laravel 8.40.0
- PHP 7.3.28
- XDebug 2.7.2
- Nginx 1.19.6
- Postgres 13.1
- PGAdmin 4

<hr/>

<p align="center"><h4>Предварительная настройка</h4></p>

<hr/>

Для работы программы необходим запущенный Docker. Указанные далее команды выполняются в консоли Bash в корне проекта.


В первую очередь, необходимо настроить <b><i>.env</i></b> файл (переименовать файл <b><i>.env.example</i></b> в корне проекта), а именно следующие данные:<br/>
<b>
- DB_USERNAME=ИМЯ
- DB_PASSWORD=ПАРОЛЬ_1
</b>
и:<br/>
<b>
- PGADMIN_DEFAULT_EMAIL=АДРЕС_ПОЧТЫ
- PGADMIN_DEFAULT_PASSWORD=ПАРОЛЬ_2
</b>

Также нужно создать volume'ы для PostgreSQL и PGAdmin:<br/>
<b><i>docker volume create --name=postgres_data</i></b><br/>
<b><i>docker volume create --name=pgadmin_data</i></b>

<hr/>

<p align="center"><h4>Запуск</h4></p>

<hr/>

Сборка и запуск конфигурации:<br/>
<b><i>docker-compose up --build -d</i></b>

Остановка:<br/>
<b><i>docker-compose down</i></b>

<hr/>

<p align="center"><h4>Debug в среде разработки PhpStorm</h4></p>

<hr/>

Для работы и debug'а в PhpStorm необходимо:

1. Изменить настройки PhpStorm ("File" – "Settings"). Во вкладке "Build, Execution, Deployment" – "Docker" необходимо добавить новый Docker. Чуть ниже должно быть показано сообщение "Connection successful" (должен быть запущен Docker);

2. Собрать образ PHP (или сразу всю конфигурацию). Далее "File" – "Settings" – "Languages & Frameworks" – "PHP". Выбрать версию PHP 7.3, CLI установить по контейнеру PHP по файлу docker-compose (в открывшемся окне XDebug должен быть успешно определён), и в "Include Path" добавить путь к корню проекта;

3. "File" – "Settings" – "Languages & Frameworks" – "PHP" – "Debug". Изменить "Debug port" на 9003;

4. "File" – "Settings" – "Languages & Frameworks" – "PHP" – "Servers". Добавить сервер Docker и настроить путь (path mapping) от корня проекта к "/usr/share/nginx/html";

5. Включить "Listening for PHP Debug Connections" справа сверху окна PhpStorm.

Для откладки XDebug в файлах представлений и др. файлах <b><i>.php</i></b> и <b><i>.blade.php</i></b> (не контроллеров), вставлять в код:
<b><i><?php xdebug_break(); ?></i></b>

<hr/>

<p align="center"><h4>Настройка</h4></p>

<hr/>

При запуске конфигурации в первый раз, необходимо обновить composer в корне контейнера php:<br/>
<b><i>winpty docker exec -it php //bin//sh</i></b><br/>
<b><i>cd ..</i></b><br/>
<b><i>composer update</i></b><br/>
<b><i>exit</i></b>

Также, тоже в корне контейнера php, необходимо сгенерировать ключ приложения:<br/>
<b><i>winpty docker exec -it php //bin//sh</i></b><br/>
<b><i>cd ..</i></b><br/>
<b><i>php artisan key:generate</i></b><br/>
<b><i>exit</i></b>

Сам ключ будет занесён в переменную <b>APP_KEY</b> в файле <b><i>.env</i></b>.

<hr/>

<p align="center"><h4>Миграции БД</h4></p>

<hr/>

...

<hr/>

<p align="center"><h4>Работа приложения</h4></p>

<hr/>

Переход в само веб-приложение по адресу сервера (порт 80):<br/>
<b><i>http://localhost/ </i></b>

Переход в PGAdmin по порту 8080:<br/>
<b><i>http://localhost:8080/ </i></b>

<hr/>
