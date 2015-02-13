# VDF Parser

An open-source VDF parser for Valve's proprietary format used in Source games.

## Installation

### Via Composer

Add the following to your `composer.json` file:

```json
"require": {
    "lukezbihlyj/vdf-parser": "~1.0"
}
```

And run `composer update` to pull in the new dependency.

## Usage

To decode a VDF file you should pass the contents to the Parser class. An example is available below:

```php
$parser = new VdfParser\Parser;
$array = $parser->parse($string);
```

## Testing

Unit tests are available and we strive to achieve 100% code coverage. To run the tests, run the following:

```bash
$ composer install
$ php vendor/bin/phpunit -c test/phpunit.xml
```

In addition to the phpunit results being output to the terminal, code coverage documentation will be generated under the `build/` directory.
