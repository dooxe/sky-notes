# Apache (.htaccess or httpd.conf)
RewriteBase /{{APP_PATH}}
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule api/. /api.php [L]
