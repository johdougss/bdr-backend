### System
The system uses the framework laravel
[documentation](https://laravel.com/docs/5.2)

### Required
* PHP >= 5.5.9
* OpenSSL PHP Extension
* PDO PHP Extension
* Mbstring PHP Extension
* Tokenizer PHP Extension
* MySQL


### Install or Access [http://backend.johdoug.com/api/task](http://backend.johdoug.com/api/task)
Clone the repository to your Apache server.
```
git clone https://github.com/johnathansantos/bdr-backend.git
```

Composer install

```
$ composer install
```


Config .env

```
$ cd ex1/
$ cp .env.example .env
```

config database
```
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=secret
```

Generate APP_KEY
```
$ php artisan key:generate
```

Permission folder storage
```
$ chmod 777 -R storage
```

or set your virtual hosts:
```
<VirtualHost *:80>
    ServerAdmin admin@backend.dev
    ServerName backend.dev
    ServerAlias www.backend.dev *.backend.dev
    ErrorLog ${APACHE_LOG_DIR}/backend.com-error.log
    CustomLog ${APACHE_LOG_DIR}/backend.com-access.log combined
    DocumentRoot "/var/www/bdr-backend/ex1/public"

    <Directory "/var/www/bdr-backend/ex1/public">
        Allowoverride All
    </Directory>
</VirtualHost>
```

In exercise 1 is required to include the database that is in the project root
[dump.sql](https://github.com/johnathansantos/bdr-backend/blob/master/ex1/db/dump.sql)
```
db/dump.sql
```

Access your browser's address:

```
http://localhost/bdr-backend/ex1/public/api/task
```

or access the hosted system:
[http://backend.johdoug.com/api/task](http://backend.johdoug.com/api/task)





## (1) DEVELOPING A NEW TOOL (Web service/API only. No user interface needed.)

### User Stories
**1) As a guest user, I want to see the items of my TO DO list, so that I can see what tasks I need to work on.**

**ACCEPTANCE CRITERIA:**
* The API must be developed using REST concepts and practices.
* The user must be able to get the list of all existing tasks.

```
GET http://backend.johdoug.com/api/task
```

* The user must be able to get the details of a task.


```
// {id} - task_id - sample: http://backend.johdoug.com/api/task/1
GET http://backend.johdoug.com/api/task/{id}
```

* In case there is no task, the API must return the following message: "Wow. You have nothing else to do. Enjoy the rest of your day!".
```
// done - {true|false}
GET http://backend.johdoug.com/api/task?done=true
```


**2) As a guest user, I want to add a new item into my TO DO list, so that I can store my tasks.**

```
POST http://backend.johdoug.com/api/task
payload: content=samplecontent&type=shopping
```

Sample create:
response header (201 created):
```
Location: http://backend.johdoug.com/api/task/11
Content-Length: 131
Content-Type: application/json
```

```
{
"content": "samplecontent"
"type": "shopping"
"done": false
"sort_order": "2147483647"
"date_created": "2016-03-19 02:40:51"
"uuid": 11
}
```

**ACCEPTANCE CRITERIA:**
* The API must be developed using REST concepts and practices.
* The system must not allow empty tasks. If that happens, then the API must return the following message: "Bad move! Try removing the task instead of deleting its content.".
* The system must set the date in which the item was created automatically.
* UUID must be automatically generated and it must be unique.
* The task Type must only allow "shopping" or "work". If another type is passed, then the API must return the following message: "The task type you provided is not supported. You can only use shopping or work.".

**3) As a guest user, I want to delete a task from my TO DO list, so that I can discard the tasks that I will no longer need to do.**
```
// {id} - task_id - sample: DELETE http://backend.johdoug.com/api/task/1
DELETE http://backend.johdoug.com/api/task/{id}
```

**ACCEPTANCE CRITERIA:**
* The API must be developed using REST concepts and practices.
* The user must be able to delete an existing task.
* If the task isn't valid anymore, the API must return the following message: "Good news! The task you were trying to delete didn't even exist.".

**4) As a guest user, I want to prioritize the tasks of my TO DO list, so that I can organize my work and always deliver the most valuable things first.**

**ACCEPTANCE CRITERIA:**
* The API must be developed using REST concepts and practices.
* The user must be able to edit the information of an existing task.
```
// {id} - task_id - sample: PUT http://backend.johdoug.com/api/task/2
PUT http://backend.johdoug.com/api/task/{id}
payload: content=samplecontent2&type=shopping
```
* If the task doesn't exist, then the API must return the following message: "Are you a hacker or something? The task you were trying to edit doesn't exist.".

**5) As a guest user, I want to prioritize the tasks of my TO DO list, so that I can organize my work and always deliver the most valuable things first.**
```
// {id} - task_id - sample: GET http://backend.johdoug.com/api/task/2/priority/1
// {priority} - number priority -  high priority [1,2,3,...45] low priority
GET http://backend.johdoug.com/api/task/{id}/priority/{priority}
```

**ACCEPTANCE CRITERIA:**
* The API must be developed using REST concepts and practices.
* The user must be able to reorder the list based on his prioritization criteria.
* If the task shares the same priority of another existing task, the the system must be smart enough to reorder the entire list and prevent priority conflicts.

### EXTRA INFORMATION
**Entity**
```
{
      "uuid": "",
      "type": "",
      "content": "",
      "sort_order" : 0,
      "done" : true|false,
      "date_created": ""
   }
```




--------------------------------------