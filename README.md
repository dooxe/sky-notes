# ![](www/logo/logo-large.png) &nbsp; Skynotes - *keep notes in your secret sky*

*Skynotes* allows creating and editing notes online
through a self-hosted easy-to-install web application.

## Features
* Notebook creation / deletion
* Note creation / deletion inside notebooks
* Note edition with a markdown editor
* Live HTML preview
* PDF generation
* Editor theme configuration

## What you need

1. An *apache* server with *command line* access
    * `mod_rewrite` installed and enabled.
    The following lines might do the job:
      ```
      sudo a2enmod rewrite
      sudo systemctl restart apache2
      ```
      Otherwise see: https://stackoverflow.com/questions/869092/how-to-enable-mod-rewrite-for-apache-2-2

    * `AllowOverride All` for `.htacces`

        This might help: https://stackoverflow.com/questions/18740419/how-to-set-allowoverride-all

2. *composer* dependency manager

    https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx
3. *nodejs / npm*

    https://nodejs.org/en/


## Installation

1. Type these commands in a terminal:
```
git clone https://github.com/dooxe/sky-notes.git
cd sky-notes
composer install
php install/install.php
```
2. Make the folder `data` writable.

You're done ! Have fun now !

Feedbacks are appreciated :)
