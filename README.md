mediaconvert-php
=======================

> This is the official PHP SDK v2 for the [MediaConvert](https://cloudconvert.com/api/v2) _API v2_. 
> For API v1, please use [v2 branch](https://github.com/cloudconvert/cloudconvert-php/tree/v2) of this repository.

Install
-------------------

To install the PHP SDK you will need to be using [Composer]([https://getcomposer.org/)
in your project. 
 
Install the SDK alongside Guzzle 7:

```bash
composer require mediaconvert/mediaconvert-php
```

This package is not tied to any specific HTTP client. Instead, it uses [Httplug](https://github.com/php-http/httplug) to let users choose whichever HTTP client they want to use.

If you want to use Guzzle 6 instead, use:

```bash
composer require cloudconvert/cloudconvert-php
```

You can use the [MediaConvert Api](https://developer.media.io/api-introduction.html) to see the available options for the various task types.

Resources
---------

* [API Documentation](https://developer.media.io/)