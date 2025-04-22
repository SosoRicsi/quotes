<?php

namespace JarkoRicsi\Quote\Facade;

use Illuminate\Support\Facades\Facade;

class QuoteFacade extends Facade
{
	protected static function getFacadeAccessor()
	{
		return 'quote';
	}
}