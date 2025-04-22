<?php

use Illuminate\Support\ServiceProvider;
use JarkoRicsi\Quote\Quote;

class QuoteServiceProvider extends ServiceProvider
{
	public function register()
	{
		$this->app->singleton(Quote::class, function($app) {
			return new Quote(config('quote.language_path'), config('quote.language'));
		});

		$this->app->alias(Quote::class, 'quote');
	}

	public function boot()
	{
		//
	}
}