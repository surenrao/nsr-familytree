-----------
MIT License 
-----------

Copyright (c) 2008, Suryanarayana Nyayapati

Permission is hereby granted, free of charge, to any person
obtaining a copy of this software and associated documentation
files (the "Software"), to deal in the Software without
restriction, including without limitation the rights to use,
copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the
Software is furnished to do so, subject to the following
conditions:

The above copyright notice and this permission notice shall be
included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
OTHER DEALINGS IN THE SOFTWARE.

---------------------
Apache Configurations
---------------------

<VirtualHost ftree:80>
	ServerName ftree
	DocumentRoot "C:/xampp/htdocs/ftree/web"
	<Directory "C:/xampp/htdocs/ftree/web">
	AllowOverride All
	Options All
	</Directory>
	php_value include_path ".;C:/xampp/htdocs/ftree/include;C:/xampp/htdocs/ftree/lib;C:/xampp/php/PEAR"
	php_value magic_quotes_gpc off
	php_value register_globals off
</VirtualHost>


For Windows add a entry in C:\WINDOWS\system32\drivers\etc\hosts

127.0.0.2       ftree

---------------------------
Develeopment Configurations
---------------------------
* Eclipse Europa PDT

* Project include path :- include, lib, PEAR

* PEAR packages in use:-
	# pear install -f Text_CAPTCHA
	# pear install -f Image_Text
	# pear install Text_Password
	
* External Libraries: Zend Framework 1.0.4, Smarty 2.6.19, jquery-1.2.3

* XAMPP: Windows Version 1.6.5

* Database: MySQL 5.0.51

* Webserver: Apache 2, PHP: 5.2.5

