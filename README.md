# Own FaaS

## Introduction
Own FaaS is self hosted FaaS (Function as a Service). It is self hosted alternative to Amazon Lambda, Google Cloud Functions and Azure Functions. Easy to install and run, with web based code editor. 
Creating, editing, listing and deleting functions.
Function invocations based on triggers - HTTP and Time.


![Own FaaS](https://github.com/ihidzhov/FaaS/blob/main/screenshots/ScreenshotHttps.png?raw=true&v=1 "Own FaaS")

## :high_brightness: Features
- Self hosted FaaS
- Easy set up
- Create, list, edit and delete functions
- Triggers - HTTP
- Triggers - Time based triggers (crontab)
- Web based code editor
- Logs for every function invocation
- User preferences (HTML theme and code editor theme)

## :rocket: Upcoming features
- Composer.json file to every function
- More and more detailed logs
- Error logs
- Documentation in the project itself

## :rabbit: Quick start

```Bash
git clone https://github.com/ihidzhov/FaaS
cd FaaS
php database/migrations.php
php -S localhost:9090 
```

It is better to move the project to web servers like Apache or NGINX.


## :floppy_disk: Used tech
- [PHP](https://github.com/php/php-src)
- [SQLite](https://sqlite.org)
- [Composer](https://getcomposer.org)
- [Bootstrap](https://getbootstrap.com/)
- [Ace](https://ace.c9.io/)
 
## :angel: Contributing
Thank you for considering contributing to Own FaaS.

## :exclamation: License
The Own FaaS is open-sourced software licensed under the MIT license(LICENSE).



 
 
