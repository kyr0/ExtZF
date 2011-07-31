ExtZF - Sample project how to integrate ZF, Ext JS 4, Ext.Direct and Doctrine 2
===============================================================================

License: MIT license
Author:  Aron Homberg <info@aron-homberg.de>
Press:   There is a news article released in the german PHP-Magazin related to
         this sample project code. (Release: 09/2011)


Thirdpary code
==============

Portions of the code contained in the /thirdparty, /library/Doctrine and
/library/Zend may be released under different open source licenses such as
GPLv3, LGPL or Apache License.


About
=====

This sample projects shows how to integrate Zend Framework nicely
with Ext JS 4 and Doctrine 2 via Ext.Direct combined
with a smart Ant-driven build process (This part can be optimized).

What do you need to run this project?
- An installation of Ant, JDK
- An installation of PHP 5.3+
- A running MySQL 5+ daemon
- A running webserver, best-case Apache 2

An Apache 2 orientated vHost configuration for this project is provided below:


Setup
=====

0. Create a vHost in for your webserver system (For Apache 2 see below!)
1. Change the values in /application/config/*.ini according to your system
2. Create a database called "extzf" in your MySQL instance
3. Run "ant init" in the root folder

Nice to know:

x If you've changed some code, run "ant rebuild" or simply "ant" to
  generate a new optimized release out of the changed sources

x JavaScript and CSS debug mode can be enabled by loading the page by
  appending the URL GET-parameter "?debug=true"


Sample vHost config
===================

Notice: The "release" directory is correct. It will be created by the build process!

Listen localhost:780
<VirtualHost localhost:780>
    ServerAdmin webmaster@localhost

    DocumentRoot "E:\art-zf\release\public"

    <Directory "E:\art-zf\release\public">
        Options Indexes FollowSymLinks MultiViews
        AllowOverride All
        Order allow,deny
        allow from all
    </Directory>

    ErrorLog "E:\art-zf\log\apacheerror.log"

    # Possible values include: debug, info, notice, warn, error, crit,
    # alert, emerg.
    LogLevel warn

    CustomLog "E:\art-zf\log\apacheaccess.log" combined

</VirtualHost>