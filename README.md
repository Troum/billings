# Planned transfers system

## First step

Check if you have installed `composer` in your system. If you haven't - you must to install it using https://getcomposer.org/.
After installing of `composer` you have to locate directory with cloned repository and run this command `composer install`.

## Second step

After installation of all needed dependencies, you have to run `npm install` to install all needed front-end dependencies.

## Third step

After installing you have to setup `.env` file. You have to just rename `.env.example` to `.env`.
After that you have to generate application key by running next command `php artisan key:generate`.
As soon as this system use **JWT Authentication** you need to generate `jwt-key`.
Run this command `php atisan jwt:secret`

## Fourth step

This system using **ALGOLIA Scout**. So for testing system was created specific account and got API keys to work with ALGOLIA Scout.
To use it paste this code in `.env` file.

  **ALGOLIA_APP_ID=GM49SKNHR9**
  
  **ALGOLIA_SECRET=843fb54f26edfdcbcd35a24bf6026c32**
  
## Fifth step

Setup database connection in `.env` file.
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```
To work with Algolia scout you need to set SCOUT_QUEUE=true:
```
SCOUT_QUEUE=true
```
After that you need to run `php artisan config:cache` and `php artisan migrate`

## Sixth step

You need to fill database with testing values. For this you need to run `php artisan db:seed`. This command will create 50 fake users.
Now you have to insert this data to ALGOLIA Scout.
Just run this command `php artisan scout:import`. If you have got response like below

![alt-text](http://i66.tinypic.com/anzqrq.png "Successfully imported to Algolia")

All is ok.

## Seventh step

Now you can run project. If you have installed **PHP** on your machine (require **PHP>=7.1**) - you can just run `php artisan serve`
If you not - you can use VM or anything else.

**Note**: if you change URL to project in your system (http://example.loc instead of http://localhost:8000/) you have to change it in
 `axios-plugin.js` file to configure working via API.
 
If you want to login, just click on "Dasboard" that placed on nav-panel - and you will path to login page form. If you want - you can register in system.
Just click "Register" link placed on login form.

## Planned working

To use planned (on server) you need to setup **Crone**

```
* * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
```
To test schedule, run this command `php artisan schedule:run` in console 

 
