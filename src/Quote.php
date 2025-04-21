<?php

namespace JarkoRicsi\Quote;

use JarkoRicsi\Quote\Exceptions\LanguageFileNotFoundException;

/**
 * A simple, easy-to-use Quote package for PHP.
 */
class Quote
{
	/**
	 * @var string The path to the language files.
	 */
	protected string $language_path;

	/**
	 * @var string The language of the application.
	 */
	protected string $language;

	/**
	 * @var array The file for the given language which contains the quotes.
	 */
	protected array $language_file;

	/**
	 * @param string $language_path The path to the language files.
	 * @param string $language The language of the application.
	 */
	public function __construct(
		string $language_path,
		string $language,
	) {
		$this->language = $language;
		$this->language_path = $language_path;

		$this->checkLanguageFile();

		$this->language_file = require $language_path . '/' . $language . '.php';
	}

	/**
	 * Generate a random quote from the language file.
	 * 
	 * @return array<string, string>
	 */
	public function random(): array
	{
		return $this->language_file[array_rand($this->language_file)];
	}

	/**
	 * Get all quote authors from the language file.
	 * 
	 * @return array<string>
	 */
	public function getAllAuthors(): array
	{
		$authors = [];

		foreach ($this->language_file as $quote) {
			$authors[] = $quote['author'];
		}

		return $authors;
	}

	/**
	 * Get all quotes from an author.
	 * 
	 * @param string $author The name of the author.
	 * @return array<string>
	 */
	public function getAllQuotesByAuthor(string $author): array
	{
		$quotes = [];

		foreach ($this->language_file as $quote) {
			if ($quote['author'] === $author) {
				$quotes[] = $quote['quote'];
			}
		}

		return $quotes;
	}

	/**
	 * Check for the language file.
	 * 
	 * @return void
	 * @throws LanguageFileNotFoundException
	 */
	protected function checkLanguageFile(): void
	{
		$language_file = file_exists($this->language_path . '/' . $this->language . '.php');

		if (!$language_file) {
			throw new LanguageFileNotFoundException("Language [{$this->language}] file for quote not found!");
		}
	}
}
