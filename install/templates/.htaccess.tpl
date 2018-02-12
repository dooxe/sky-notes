<IfModule mod_rewrite.c>
    Options -MultiViews -Indexes
    RewriteEngine on
    RewriteCond %{HTTP:X-Requested-With} !=XMLHttpRequest
    RewriteCond %{HTTP:X-REQUESTED-WITH} !^(XMLHttpRequest)$
    # https://www.siteground.com/kb/how_to_change_my_document_root_folder_using_an_htaccess_file/
    RewriteCond %{REQUEST_URI} !www/
    RewriteRule (.*) /{{APP_PATH}}/www/$1 [L]
    RewriteRule api/(.*) /{{APP_PATH}}/www/api.php [L]
</IfModule>
