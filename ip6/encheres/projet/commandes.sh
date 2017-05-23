#!/bin/sh
/Applications/XAMPP/bin/php-5.5.6 vendor/propel/propel/bin/propel.php reverse
cp generated-reversed-database/schema.xml .
/Applications/XAMPP/bin/php-5.5.6 vendor/propel/propel/bin/propel.php model:build
/Applications/XAMPP/bin/php-5.5.6 composer.phar dump-autoload
