<?php
namespace System\Libs\Exception;

use Exception;

class ExceptionHandler
{
	public function __construct($title, $body)
	{
		throw new Exception(strip_tags($title . ': ' . $body), 1);		
	}
}