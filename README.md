# ![](www/logo/logo-large.png) &nbsp; Skynotes - *keep notes in your secret sky*

*Skynotes* allows creating and editing notes online
through a self-hosted easy-to-install web application.

## Main features
* Notebook creation / deletion
* Note creation / deletion inside notebooks
* Note edition with a powerful Markdown editor
* Live HTML preview
* PDF generation
* Editor theme configuration

## Installation

### What you need

1. An *apache* server with *command line* access
2. *composer* dependency manager

    https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx
3. *nodejs / npm*

    https://nodejs.org/en/


### How to do

Type these commands in a terminal:
```
git clone https://github.com/dooxe/sky-notes.git
cd sky-notes/www/
npm install
composer install
cd ..
php install/install.php
chmod 777 -R data
```

You're done ! Have fun now !

Feedbacks are appreciated :)
