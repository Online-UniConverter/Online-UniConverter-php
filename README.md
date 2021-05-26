Online-UniConvert-php
=======================

> This is the official PHP SDK v2 for the [OnlineUniConvert](https://developer.media.io/api-introduction.html) _API v2_. 

[![Tests](https://github.com/Online-UniConverter/Online-UniConverter-php/actions/workflows/run-tests.yml/badge.svg)](https://github.com/Online-UniConverter/Online-UniConverter-php/actions/workflows/run-tests.yml)
[![Latest Stable Version](https://poser.pugx.org/onlineuniconvert/onlineuniconvert-php/v)](//packagist.org/packages/onlineuniconvert/onlineuniconvert-php) 
[![Total Downloads](https://poser.pugx.org/onlineuniconvert/onlineuniconvert-php/downloads)](//packagist.org/packages/onlineuniconvert/onlineuniconvert-php) 
[![Latest Unstable Version](https://poser.pugx.org/onlineuniconvert/onlineuniconvert-php/v/unstable)](//packagist.org/packages/onlineuniconvert/onlineuniconvert-php) 
[![License](https://poser.pugx.org/onlineuniconvert/onlineuniconvert-php/license)](//packagist.org/packages/onlineuniconvert/onlineuniconvert-php)

Install
-------------------

To install the PHP SDK you will need to be using [Composer]([https://getcomposer.org/)
in your project. 
 
Install the SDK alongside Guzzle 7:

```bash
composer require OnlineUniConvert/OnlineUniConvert-php
```

This package is not tied to any specific HTTP client. Instead, it uses [Httplug](https://github.com/php-http/httplug) to let users choose whichever HTTP client they want to use.

If you want to use Guzzle 6 instead, use:

```bash
composer require onlineuniconvert/onlineuniconvert-php
```

You can use the [OnlineUniConvert Api](https://developer.media.io/api-introduction.html) to see the available options for the various task types.

Creating Import Tasks
-------------------
```php
use OnlineUniConvert\Models\Import;

// init
$import = (new Import('import/upload'));
$this->OnlineUniConvert->imports()->create($import);

// upload
$response = $this->OnlineUniConvert->imports()->upload($import, fopen(__DIR__ . '/files/单独.mov', 'r'), 'vid00084source.mov');
var_dump($response);

// info
$this->OnlineUniConvert->imports()->info($import);
var_dump($import);
```

Creating Convert Tasks
-------------------
```php
use OnlineUniConvert\Models\Task;

// init
$task = (new Task('convert'))->set('input', 'jnthak3k-amuk-bj8l-cj7h-nn1yno4jty8i')->set('output_format', 'mp4');
$this->OnlineUniConvert->tasks()->create($task);
var_dump($task);

// info
$this->OnlineUniConvert->tasks()->info($task);
var_dump($task);
```

Creating Export Tasks
-------------------
```php
use OnlineUniConvert\Models\Common;
use OnlineUniConvert\Models\Export;

// init
$export = (new Export('export/url'))->set('input', '2w2y610m-awgo-bt8q-cq2p-981fu1w1bmr0');
$this->OnlineUniConvert->exports()->create($export);
var_dump($export);

// info
$this->OnlineUniConvert->exports()->info($export);
var_dump($export);

// download
$source = $this->OnlineUniConvert->getHttpTransport()->download($export->getResult()->files[0]->url)->detach();

$dest = tmpfile();
$destPath = stream_get_meta_data($dest)['uri'];
stream_copy_to_stream($source, $dest);
```

You can use the [OnlineUniConvert](https://developer.media.io/api-introduction.html) to see the available options for the various task types.

Unit Tests
-----------------

    vendor/bin/phpunit --testsuite unit

Feature Tests
-----------------

    vendor/bin/phpunit --testsuite feature

By default, this runs the integration tests against the Sandbox API with an official OnlineUniConvert account. If you would like to use your own account, you can set your API key using the `ONLINEUNICONVERT_API_KEY` enviroment variable. In this case you need to whitelist the following MD5 hashes for Sandbox API (using the OnlineUniConvert dashboard).

    684321sdfew31fsdfes6812381e2ewr2  input.mp4
    68531sdfsdf684sefsd68465sdfesf28  input.png
    
Resources
---------

* [API Documentation](https://developer.media.io/)