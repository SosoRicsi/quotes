<?php

namespace JarkoRicsi\Quote;

use JarkoRicsi\Quote\Exceptions\AuthorNotFoundException;
use JarkoRicsi\Quote\Exceptions\LanguageFileNotFoundException;
use JarkoRicsi\Quote\Exceptions\NoQuotesByAuthorException;

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
	 * @return array<string, string> A random quote from the language file. Contains the author and the quote.
	 */
	public function random(): array
	{
		return $this->language_file[array_rand($this->language_file)];
	}

	/**
	 * Get all quote authors from the language file.
	 * 
	 * @return array<string> All of the authors.
	 */
	public function getAllAuthors(): array
	{
		$authors = [];

		foreach ($this->language_file as $quote) {
			$authors[] = $quote['author'];
		}

		return array_unique($authors);
	}

	/**
	 * Get all quotes from an author.
	 * 
	 * @param string $author The name of the author.
	 * @return string[] All quotes from the author.
	 * @throws NoQuotesByAuthorException
	 */
	public function getAllQuotesByAuthor(string $author): array
	{
		$quotes = [];

		foreach ($this->language_file as $quote) {
			if ($quote['author'] === $author) {
				$quotes[] = $quote['quote'];
			}
		}

		if (empty($quotes)) {
			throw new NoQuotesByAuthorException("No quotes found for author [{$author}].");
		}

		return $quotes;
	}

	/**
	 * Get a random quote from a specific author.
	 * 
	 * @param string $author The name of the author.
	 * @return string The random quote from the author.
	 * @throws NoQuotesByAuthorException
	 */
	public function getRandomQuoteByAuthor(string $author): string
	{
		$quotes = $this->getAllQuotesByAuthor($author);

		if (empty($quotes)) {
			throw new NoQuotesByAuthorException("No quotes found for author [{$author}].");
		}

		return $quotes[array_rand($quotes)];
	}

	/**
	 * Get a random author from the language file.
	 * 
	 * @return string The random author.
	 * @throws AuthorNotFoundException
	 */
	public function getRandomAuthor(): string
	{
		$authors = $this->getAllAuthors();

		if (empty($authors)) {
			throw new AuthorNotFoundException("No authors found in the language file.");
		}

		return $authors[array_rand($authors)];
	}

	/**
	 * Get all informations from the language file.
	 * 
	 * @return array{
	 *     number_of_quotes: int,
	 *     all_quotes: array<int, array<string, string>>,
	 *     number_of_authors: int,
	 *     all_authors: array<int, string>
	 * }
	 */
	public function getQuotesInformation(): array
	{
		return [
			'number_of_quotes' => count(array_values($this->language_file)),
			'all_quotes' => array_values($this->language_file),
			'number_of_authors' => count($this->getAllAuthors()),
			'all_authors' => $this->getAllAuthors()
		];
	}

	/**
	 * Check for the language file.
	 * 
	 * @return void
	 * @throws LanguageFileNotFoundException
	 */
	protected function checkLanguageFile(): void
	{
		$file_path = file_exists($this->language_path . '/' . $this->language . '.php');

		if (!$file_path) {
			throw new LanguageFileNotFoundException("Language [{$this->language}] file for quote not found!");
		}
	}
}
