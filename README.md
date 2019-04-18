# TO DO Real-time V 1.0
This is a To Do Task list CRUD Real-time Application. In this app a user can create, read, edit and delete to do task and can see real-time changes of other user in to do task.

### V 1.0
   In this version app has real-time data refresh by calling HTTP requests in fix time interval.
### V 2.0
   Next version would have real-time data refresh by websocket and Laravel broadcasting events. 
### V 3.0
   In version 3.0 app would have a benchmark of comparing both versions' way of refreshing data. 

## Setup
Following instructions will give a copy of this This Application up and running in any local machine for testing purposes.

### Prerequisites

This app's back-end build with Laravel framework and font-end bundled with Node.
Following apps should installed in machine in order to config this app.

- [Bash](https://www.gnu.org/software/bash/).
- [PHP](https://www.php.net/downloads.php).
- [Composer CLI](https://getcomposer.org/download/).
- [Node Package Manager CLI](https://nodejs.org/en/download/)

### Installing
- Clone this App from the master branch,
- Open Terminal/Bash and run following comands:
  - To Config App:
  ```
  cd <app cloned dir>
  bash configApp --app
  ```
  - Config MySQL Connection
  ```
  bash configApp --sql
  ```
## Run
  - To Run back-end server for App:
  ```
  cd <app cloned dir>
  bash configApp --run
  ```
  - To Run front-end development watch:
  ```
  bash configApp --watch
  ```

## Built With

* [Laravel](https://laravel.com/) - PHP Framework;
* [Vue](https://vuejs.org/) - JavaScript Framework;

## Authors

* [Deep Panchal](http://deeppanchal.com/) - Developer;
