<?php

namespace JarkoRicsi\Quote\Facade;

use Illuminate\Support\Facades\Facade;

class Quote extends Facade
{
	protected static function getFacadeAccessor()
	{
		return 'quote';
	}
}