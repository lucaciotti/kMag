
Insert these lines in the php file:
-ini_set('display_errors', 1);
-ini_set('display_startup_errors', 1);
-error_reporting(E_ALL);

Rempber to Install CURL!!
-sudo apt-get install php5-curl
-modify php.ini

If on Windows:
Go to your php.ini file and remove the ; mark from the beginning of the following line:
;extension=php_curl.dll