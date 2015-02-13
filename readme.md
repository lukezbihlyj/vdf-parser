# VDF Parser

An open-source VDF parser for Valve's proprietary format used in Source games. This package is 100% tested and available for use in any project under the MIT license.

## Installation

### Via Composer

Add the following to your `composer.json` file and run `composer update` to update the dependencies and pull in the new package.

```json
"require": {
    "lukezbihlyj/vdf-parser": "~1.0"
}
```

## Usage

### Parsing

```php
$string = <<<VDF
{
    "key" "value"
}
VDF;

$parser = new VdfParser\Parser;
$result = $parser->parse($string);

//
// $result = [
//     'key' => 'value'
// ]
//
```

## Testing

Unit tests are available and we strive to achieve 100% code coverage. Running the test suite is incredibly simple.

```bash
$ composer install
$ php vendor/bin/phpunit -c test/phpunit.xml
```

In addition to the phpunit results being output to the terminal, code coverage documentation will also be generated under the `build/` directory.
