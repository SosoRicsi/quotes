# JarkoRicsi\Quote

A simple, elegant, and easy-to-use PHP package to manage and retrieve inspirational quotes.

## Features

* Get a random quote
* Retrieve all available authors
* Retrieve all quotes by a specific author
* Get a random quote by a specific author
* Get a random author
* Retrieve full statistics about quotes and authors
* Support for multiple languages via separate language files
* Custom exception handling for better error control

## Installation

Install via Composer:

```bash
composer require jarkoricsi/quote
```

> Update your autoload configuration if necessary.

## Language File Format

Language files are simple PHP files that return an array of associative arrays. Each item must contain an `author` and a `quote` key:

```php
<?php

return [
    [
        'author' => 'Albert Einstein',
        'quote' => 'Imagination is more important than knowledge.'
    ],
    [
        'author' => 'Oscar Wilde',
        'quote' => 'Be yourself; everyone else is already taken.'
    ],
];
```

## Basic Usage

```php
use JarkoRicsi\Quote\Quote;

$quote = new Quote(__DIR__ . '/lang', 'en');

// Get a random quote
$random = $quote->random();
echo "{$random['author']}: {$random['quote']}";

// Get all authors
$authors = $quote->getAllAuthors();

// Get quotes by author
$einsteinQuotes = $quote->getAllQuotesByAuthor('Albert Einstein');

// Get a random quote by a specific author
$einsteinQuote = $quote->getRandomQuoteByAuthor('Albert Einstein');

// Get a random author
$randomAuthor = $quote->getRandomAuthor();

// Get statistics
$info = $quote->getQuotesInformation();
```

## Available Methods

| Method                       | Description                                 |
| ---------------------------- | ------------------------------------------- |
| `random()`                 | Returns a random quote                      |
| `getAllAuthors()`          | Returns an array of all authors             |
| `getAllQuotesByAuthor()`   | Returns all quotes by the specified author  |
| `getRandomQuoteByAuthor()` | Returns a random quote by the author        |
| `getRandomAuthor()`        | Returns a random author                     |
| `getQuotesInformation()`   | Returns summary statistics about the quotes |

## Exception Handling

| Exception                         | When it is thrown                                          |
| --------------------------------- | ---------------------------------------------------------- |
| `LanguageFileNotFoundException` | If the specified language file cannot be found             |
| `AuthorNotFoundException`       | If there are no authors in the language file               |
| `NoQuotesByAuthorException`     | If the specified author has no quotes in the language file |

## Example Directory Structure

```
project/
├── lang/
│   └── en.php
├── src/
│   └── Quote.php
└── index.php
```

## License

[CGLJR](./licence.md)
