<IfModule mod_rewrite.c>
    Options -MultiViews

    RewriteEngine On
    RewriteBase /{{APP_PATH}}/
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule api/. api.php [L]
</IfModule>
