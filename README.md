<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<hr/>

<p align="center"><h3>АИС "Прохождение производственной практики"</h3></p>

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
