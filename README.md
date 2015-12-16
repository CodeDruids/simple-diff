# SimpleDiff

[![Latest release](http://img.shields.io/github/release/CodeDruids/simple-diff.svg)](https://github.com/CodeDruids/hello-world-composer/releases)
[![Build Status](https://img.shields.io/travis/CodeDruids/simple-diff/master.svg)](https://travis-ci.org/CodeDruids/simple-diff)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/CodeDruids/simple-diff.svg)](https://scrutinizer-ci.com/g/CodeDruids/simple-diff/)
[![Code Quality](https://img.shields.io/scrutinizer/g/CodeDruids/simple-diff.svg)](https://scrutinizer-ci.com/g/CodeDruids/simple-diff/)
[![Software License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)

SimpleDiff is a PHP class wrapper for a simple diffing algorithm.

## Requirements

* PHP 5.3 or higher

## Installation

Add the following to your `composer.json`:

```json
{
    "require": {
        "CodeDruids/simple-diff": "1.*"
    }
}
```

## Basic Usage

```php
$old = ['some','array','of','stuff'];
$new = ['some','array','of','other','stuff'];

$diff = \CodeDruids\SimpleDiff::diff($old, $new);

$oldHtml = "Some <b>HTML</b> you simply <i>cannot</i> ignore!";
$newHtml = "Some <b>HTML</b> you just <i>cannot</i> ignore!";

$htmlDiff = \CodeDruids\SimpleDiff::htmlDiff($oldHtml, $newHmtl);

```

## Support

If you believe you have found a bug, please report it using the [GitHub issue tracker](https://github.com/CodeDruids/simple-diff/issues),
or better yet, fork the library and submit a pull request.