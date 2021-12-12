# redbox-cli 1.5

![redbox-logo-klein](https://cloud.githubusercontent.com/assets/121194/12361779/5af96e52-bbc0-11e5-91b0-2b7afbc1e5cc.png)

[![Code Coverage](https://img.shields.io/endpoint?url=https://raw.githubusercontent.com/johnnymast/redbox-cli/1.5/coverage.json)](https://github.com/johnnymast/redbox-cli/actions/workflows/Coverage.yml)
[![Pest Unit Tests](https://github.com/johnnymast/redbox-cli/actions/workflows/Pest.yml/badge.svg)](https://github.com/johnnymast/redbox-cli/actions/workflows/Pest.yml)
[![Phpstan](https://github.com/johnnymast/redbox-cli/actions/workflows/PhpStan.yml/badge.svg)](https://github.com/johnnymast/redbox-cli/actions/workflows/PhpStan.yml)


[![Build Status](https://travis-ci.org/johnnymast/redbox-cli.svg)](https://travis-ci.org/johnnymast/redbox-cli) 
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/johnnymast/redbox-cli/badges/quality-score.png?b=1.5)](https://scrutinizer-ci.com/g/johnnymast/redbox-cli/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/johnnymast/redbox-cli/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/johnnymast/redbox-cli/?branch=1.5)
[![Twitter URL](https://img.shields.io/twitter/url/http/shields.io.svg?style=social&label=Contact%20author)](https://twitter.com/intent/tweet?text=@mastjohnny)

# redbox-cli 1.5
This is a command line parser based on [Climate](https://github.com/thephpleague/climate)  by [Joe Tannenbaum](https://github.com/joetannenbaum). We share a lot of similarities but i desided to take the getopt route and downgrade the number of lines in the code by 1/4 of the original size.

## Documentation

For detailed documentation of the project you can visit the [documentation page](https://johnnymast.github.io/redbox-cli/).

## Installation

Using [composer](https://packagist.org/packages/redbox/cli):

```bash
$ composer require redbox-cli
```
## Requirements

The following versions of PHP are supported by this version.
  
+ PHP >= 8.0

### Unit Tests

If you wish to run any tests on this package you can run:

```bash
$ ./vendor/bin/pest
```

or 

```bash
$ ./vendor/bin/phpunit
```

  
### Author

This package is created and maintained by Johnny Mast. For feature requests and suggestions
you could consider [e-mailing me](mailto:mastjohnny@gmail.com) or fill out an [issue](https://github.com/johnnymast/redbox-cli/issues).

### The MIT License (MIT)

Copyright (c) 2020 Johnny Mast <mastjohnny@gmail.com>

> Permission is hereby granted, free of charge, to any person obtaining a copy
> of this software and associated documentation files (the "Software"), to deal
> in the Software without restriction, including without limitation the rights
> to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
> copies of the Software, and to permit persons to whom the Software is
> furnished to do so, subject to the following conditions:
>
> The above copyright notice and this permission notice shall be included in
> all copies or substantial portions of the Software.
>
> THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
> IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
> FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
> AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
> LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
> OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
> THE SOFTWARE.
 
