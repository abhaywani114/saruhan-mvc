<?php
/*************************************************
* Saruhanweb MVC Framework
* Simple and Modern Web Application Framework
*
* Author 	: Saruhan Web Ajans
* Web 		: https://saruhanweb.com
* Docs 	: https://saruhan.com/mvc-dokumantasyon
* Version 	: 1.0
* Github	: http://github.com/...
* License	: MIT
*
*************************************************/

// Require Composer Autoload
require_once __DIR__ . '/vendor/autoload.php';

// Require Starter
require_once __DIR__ . '/System/Kernel/Starter.php';

// Run Kernel
new System\Kernel\Kernel();


