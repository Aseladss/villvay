## About the project

This project has been developed based on the requirement in an assesment. Laravel 7 framework was used to develop this proejct. For the interfaces I have used AdminLTE 2

•	Author: [Asela Dewanarayana](https://github.com/Aseladss) <br>


## Database Setup

DB_CONNECTION=mysql<br>
DB_HOST=127.0.0.1<br>
DB_PORT=3306<br>
DB_DATABASE=todolist<br>
DB_USERNAME=root<br>
DB_PASSWORD=<br>

Next up, we need to create the database which will be grabbed from the ```DB_DATABASE``` environment variable.
```
mysql;
create database todolist;
exit;
```

Finally, make sure that you migrate your migrations.
```
php artisan migrate
```

