# VDF Parser

A simple, not-very-tested, VDF parser for Valve's proprietary format.

## Installation

```json
{
    "require": {
        "lukezbihlyj/vdf-parser": "~1.0"
    }
}
```

## Usage

```php
<?php

$parser = new \VdfParser\Parser;
$array = $parser->parse($string);

...
```
