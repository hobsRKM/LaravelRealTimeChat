Fusionmate -  Laravel RealTime Chat Application with Task Management!
===================

Demo: http://fusionmate.com

**Demo Credentials to login as Admin** 

*Username*: demo@demo.com

*Password*: Explore@123

[![Build Status](https://scrutinizer-ci.com/g/yuvaraj-mudaliar/fusionmate/badges/build.png?b=master)](https://scrutinizer-ci.com/g/yuvaraj-mudaliar/fusionmate/build-status/master)
![](https://scrutinizer-ci.com/g/yuvaraj-mudaliar/fusionmate/badges/quality-score.png?b=master)

A real time chat based application built using laravel framework 4.2 with task management using Socket.io and Redis.

![](https://raw.githubusercontent.com/yuvaraj-mudaliar/fusionmate/master/public/plugins/gif/211.gif)

----------

Preview


Rquirements
-------------
 1. PHP  version<=7.0
 2. Mysql PHP and Node-Mysql (npm install mysql for nodejs)
 3. Redis - Windows(https://github.com/rgl/redis/downloads), Linux (https://www.digitalocean.com/community/tutorials/how-to-install-and-configure-redis-on-ubuntu-16-04)
 4. Node Js
 5. Socket.io (https://www.npmjs.com/package/socket.io)

> **Note**: Before you begin to clone, check if all the above dependencies are installed

**Step 1**

   
    
    $ git clone https://github.com/yuvaraj-mudaliar/fusionmate.git //this will create a folder 'fusionmate' and clone into it
      
   
**Step 2**

    $ cd fusionmate && composer install // install dependencies
    
      Create database 'fusionmate' in Mysql

**Step 3**
Go to root of project and open database config, server.js and edit MYSQL credentials

    $ cd  /path_to/fusionmate/app/config
    $ vi database.php    //edit mysql credentials
    $ cd /path_to/fusionmate/nodejs
    $ vi server.js
    	
	var connection = mysql.createConnection({
  	host     : 'localhost',
  	user     : 'MYSQL _USERNAME',
  	password : 'MYSQL_PASSWORD',
  	database : 'fusionmate'
	});
	
**Step 4**
Generate Database tables with test data
   

    $ cd  /path_to/fusionmate
    $ php artisan migrate
**Step 5**
Open two terminals or CMD prompt depending on OS.

In **Terminal 1**

    $ redis-server
In **Terminal 2**
   

    $ cd  /path_to/fusionmate
    $ ./realtime.sh //this will start node server
    
    **Windows**
    sh realtime.sh
  **On windows - Redis** 
  *start* > *control-panel*>*Services*
  *Scroll to redis* > *right click and click on start service* to start redis server

**Final Step**
Copy `.htaccess` and `index.php` file outside of project root folder

    $ cd /path_to/fusionmate/app/
    $ cp -R index_and_htaccess/* /path_to/

Open browser and visit 

    http://localhost

**Demo Credentials to login as Admin**

*Username*: demo@demo.com

*Password*: Explore@123

> **Note**: On linux if you get Exception Handler Error, then you need to make sure you have correct permission
	    
	    chmod -R 775 /path_to/fusionmate/app/storage

**Docs**
----

**NOTE**: Inviting members requires mail configration.By default invitations will be sent from `configured mail address`.
You can configure to add your own server.

    <?php
    //app/config/mail.php
    return array(
     
        'driver' => 'smtp',
        'host' => 'smtp.gmail.com',
        'port' => 587,
        'from' => array(
        'address' =>'<YOUR_MAIL>', 
        'name' => 'fusionmate'
        ),
        'encryption' => 'tls',
        'username'=>'<YOUR_MAIL>',
        'password' => '<PASSWORD>',
        'sendmail' => '/usr/sbin/sendmail -bs',
        'pretend' => false,
     
    );

 **On creating a new account as admin you can create**
			

 1. Team
 2. Add members to a team		 
 3. Create Project and Assign to a Team
 4. Assign Tasks to team for a project and track issues
 5. Invited Team Members will get Email Notifications to JOIN

## **Application Screen Cap** ##

 - Getting Started

![](https://github.com/yuvaraj-mudaliar/fusionmate/blob/master/public/plugins/gif/team.png?raw=true)

- Email Invite

![](https://github.com/yuvaraj-mudaliar/fusionmate/blob/master/public/plugins/gif/Invitation.png?raw=true)
 
 - Team Settings

![](https://github.com/yuvaraj-mudaliar/fusionmate/blob/master/public/plugins/gif/team_settings.png?raw=true)

 - View-Add Members-Team Preference

![](https://github.com/yuvaraj-mudaliar/fusionmate/blob/master/public/plugins/gif/team_pref.png?raw=true)

- Home Page

![](https://github.com/yuvaraj-mudaliar/fusionmate/blob/master/public/plugins/gif/home.png?raw=true)


> I had created this project as  Hobby and most of the mentioned features works well.
> Feel free to fork if you think you can add additional features or enhancements and continue development.
> **UPGRADE**:  Laravel latest version is 5+. Feel free to upgrade and dm me if you wish to upgrade with latest version in a new branch.
> https://laravel.com/docs/5.0/upgrade

&copy; 2016   
MIT LICENSE

 
