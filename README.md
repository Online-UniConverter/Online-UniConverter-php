Online-UniConverter-php
=======================

> This is the official PHP SDK v2 for the [OnlineUniConverter](https://developer.media.io/api-introduction.html) _API v2_. 

[![Tests](https://github.com/Online-UniConverter/Online-UniConverter-php/actions/workflows/run-tests.yml/badge.svg)](https://github.com/Online-UniConverter/Online-UniConverter-php/actions/workflows/run-tests.yml)
[![Latest Stable Version](https://poser.pugx.org/onlineuniconverter/onlineuniconverter-php/v)](//packagist.org/packages/onlineuniconverter/onlineuniconverter-php) 
[![Total Downloads](https://poser.pugx.org/onlineuniconverter/onlineuniconverter-php/downloads)](//packagist.org/packages/onlineuniconverter/onlineuniconverter-php) 
[![Latest Unstable Version](https://poser.pugx.org/onlineuniconverter/onlineuniconverter-php/v/unstable)](//packagist.org/packages/onlineuniconverter/onlineuniconverter-php) 
[![License](https://poser.pugx.org/onlineuniconverter/onlineuniconverter-php/license)](//packagist.org/packages/onlineuniconverter/onlineuniconverter-php)

Install
-------------------

To install the PHP SDK you will need to be using [Composer]([https://getcomposer.org/)
in your project. 
 
Install the SDK alongside Guzzle 7:

```bash
composer require onlineuniconverter/onlineuniconverter-php
```

This package is not tied to any specific HTTP client. Instead, it uses [Httplug](https://github.com/php-http/httplug) to let users choose whichever HTTP client they want to use.

If you want to use Guzzle 6 instead, use:

```bash
composer require onlineuniconverter/onlineuniconverter-php
```

You can use the [OnlineUniConverter Api](https://developer.media.io/api-introduction.html) to see the available options for the various task types.

Creating Import Tasks
-------------------
```php
use OnlineUniConverter\Models\Import;

// init
$import = (new Import('import/upload'));
$this->OnlineUniConverter->imports()->create($import);

// upload
$response = $this->OnlineUniConverter->imports()->upload($import, fopen(__DIR__ . '/files/单独.mov', 'r'), 'vid00084source.mov');
var_dump($response);

// info
$this->OnlineUniConverter->imports()->info($import);
var_dump($import);
```

Creating Convert Tasks
-------------------
```php
use OnlineUniConverter\Models\Task;

// init
$task = (new Task('convert'))->set('input', 'jnthak3k-amuk-bj8l-cj7h-nn1yno4jty8i')->set('output_format', 'mp4');
$this->OnlineUniConverter->tasks()->create($task);
var_dump($task);

// info
$this->OnlineUniConverter->tasks()->info($task);
var_dump($task);
```

Creating Export Tasks
-------------------
```php
use OnlineUniConverter\Models\Common;
use OnlineUniConverter\Models\Export;

// init
$export = (new Export('export/url'))->set('input', '2w2y610m-awgo-bt8q-cq2p-981fu1w1bmr0');
$this->OnlineUniConverter->exports()->create($export);
var_dump($export);

// info
$this->OnlineUniConverter->exports()->info($export);
var_dump($export);

// download
$source = $this->OnlineUniConverter->getHttpTransport()->download($export->getResult()->files[0]->url)->detach();

$dest = tmpfile();
$destPath = stream_get_meta_data($dest)['uri'];
stream_copy_to_stream($source, $dest);
```

You can use the [OnlineUniConverter](https://developer.media.io/api-introduction.html) to see the available options for the various task types.

Unit Tests
-----------------

    vendor/bin/phpunit --testsuite unit

Feature Tests
-----------------

    vendor/bin/phpunit --testsuite feature

By default, this runs the integration tests against the Sandbox API with an official OnlineUniConverter account. If you would like to use your own account, you can set your API key using the `ONLINEUNICONVERT_API_KEY` enviroment variable. In this case you need to whitelist the following MD5 hashes for Sandbox API (using the OnlineUniConverter dashboard).

    684321sdfew31fsdfes6812381e2ewr2  input.mp4
    68531sdfsdf684sefsd68465sdfesf28  input.png
    
Resources
---------

* [API Documentation](https://developer.media.io/)