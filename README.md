## About Project

Simple REST API task application (like Trello).

## Installation
### Requirements:
1. Php >= 7.4
2. Laravel >= 8.0
3. Mysql
4. MongoDB
### Steps
Clone this project to directory and install dependencies

``` 
$ git clone https://github.com/deimosfaceless17/trello-rest-api.git trello-rest-api 
$ cd trello-rest-api
$ composer install
$ cp .env.example .env
$ php artisan key:generate
```

Then set environment in file `.env` like in casual Laravel project.

## Target

Your task is to develop a REST API task application (like Trello).
* You need to create user authorization.
* The user can create and update boards.
* The user can attach a task to each board.
* The user can create custom labels, then he can attach multiple labels to the task.
* The task must have a status (backlog, development, done, review).
* We can filter tasks by labels, status.
* The user can attach an image to the task (the image must be cropped into 2 formats: desktop, mobile). Image cropping must be asynchronous. (http://image.intervention.io/).
* We need to keep logs in MongoDB table “logs” for each update of task (create, update, delete). Who made the change, when, and what was changed (use https://github.com/jenssegers/laravel-mongodb).

Use: Laravel 8.0, MySQL, MongoDB.
* Use policies https://laravel.com/docs/7.x/authorization#creating-policies
* Use api resources/collections - https://laravel.com/docs/7.x/eloquent-resources
* Use pagination in index endpoints


The task must be done in English. If you want to add some additional comments - do it in English as well.

Advanced (optional)

* You should have 2 image drivers (for cropping), you should choose a second driver. In config we will have image_driver = ‘intervention’ or another driver. And we can change the image driver in env file. 
* Task should have relation with 1 user. 
* You should have an endpoint for boards statistics (BoardsCollection):
    * Total tasks. 
    * Total tasks which are done.
    * Progress in percentage. 
    * The best user of the week. (The user who has completed most of the tasks).
    
### How to use

For now to watch route list type in console:
`php artisan route:list`

