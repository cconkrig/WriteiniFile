[![PHP Composer](https://github.com/cconkrig/WriteiniFile/actions/workflows/php.yml/badge.svg?branch=master)](https://github.com/cconkrig/WriteiniFile/actions/workflows/php.yml)

## WriteiniFile

Write-ini-file php library for create, remove, erase, add, and update ini file.


## Installation

Use composer for install cconkrig/write-ini-file.
```bash
composer require cconkrig/write-ini-file
```

## Usage

```php
<?php

require_once 'vendor/autoload.php';

use \WriteiniFile\WriteiniFile;
use \WriteiniFile\ReadiniFile;

$data = [
    'fruit' => ['orange' => '100g', 'fraise' => '10g'],
    'legume' => ['haricot' => '20g', 'oignon' => '100g'],
    'jus' => ['orange' => '1L', 'pomme' => '1,5L', 'pamplemousse' => '0,5L'],
];

// demo create ini file
$file = new WriteiniFile('file.ini');
$file
    ->create($data)
    ->add(['music' => ['rap' => true, 'rock' => false]])
    ->rm(['jus' => ['pomme' => '1,5L']])
    ->update(['fruit' => ['orange' => '200g']])
    ->write();

echo '<pre>'.file_get_contents('file.ini').'</pre>';
/* output file.ini
[fruit]
orange=200g
fraise=10g

[legume]
haricot=20g
oignon=100g

[jus]
orange=1L
pamplemousse=0,5L

[music]
rap=true
rock=false
*/

// Just read a file ini
var_dump(ReadiniFile::get('file.ini'));
/* output
array(4) {
  'fruit' => array(2) {
    'orange' => string(4) "200g"
    'fraise' => string(3) "10g"
  }
  'legume' => array(2) {
    'haricot' => string(3) "20g"
    'oignon' => string(4) "100g"
  }
  'jus' => array(2) {
    'orange' => string(2) "1L"
    'pamplemousse' => string(4) "0,5L"
  }
  'music' => array(2) {
    'rap' => string(4) "true"
    'rock' => string(5) "false"
  }
}
*/

$erase = (new WriteiniFile('file.ini'))->erase()->write();
// file.ini -> empty
```

## Contributing

To run the unit tests:
```bash
composer install
php vendor/bin/phpunit # or use: composer run-script test
```

## License

WriteiniFile is released under the [GNU General Public License v3.0](https://github.com/Magicalex/WriteiniFile/blob/master/LICENSE)
