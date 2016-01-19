![redbox-logo-klein](https://cloud.githubusercontent.com/assets/121194/12361779/5af96e52-bbc0-11e5-91b0-2b7afbc1e5cc.png)

[![Build Status](https://travis-ci.org/johnnymast/redbox-cli.svg)](https://travis-ci.org/johnnymast/redbox-cli) 
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/johnnymast/redbox-cli/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/johnnymast/redbox-cli/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/johnnymast/redbox-cli/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/johnnymast/redbox-cli/?branch=master)
[![GitHub stars](https://img.shields.io/badge/HHVM-Ready-green.svg)](http://hhvm.com/)
[![Twitter URL](https://img.shields.io/twitter/url/http/shields.io.svg?style=social&label=Contact author)](https://twitter.com/intent/tweet?text=@mastjohnny)

# redbox-cli
This is a command line parser based on [Climate](https://github.com/thephpleague/climate)  by [Joe Tannenbaum](https://github.com/joetannenbaum). We share a lot of similarities but i desided to take the getopt route and downgrade the number of lines in the code by 1/4 of the original code.


## Howto use it
Look in the examples folder for basic [examples](examples) of how to use the package.

## Installation

Using [composer](https://packagist.org/packages/redbox/cli):

```bash
$ composer require redbox/cli
```
## Requirements

The following versions of PHP are supported by this version.

+ PHP 5.4
+ PHP 5.5
+ PHP 5.6
+ HHVM

## Unit Testing

With the new 1.2 release we increased the test ratio from 64% in previous versions to 95% right now with the current release. Also with the new release i have found a way to unit test the core component of this package (getopt(). While doing this we can make sure your implementation
of Redbox-cli will run like a sunshine with any of your projects. If you want a litle of what our new tests cover that was not possible before checkout our [examples](examples) directory for great examples on how to use this great package.

  
  
## Author

This package is created and maintained by [Johnny Mast](https://github.com/johnnymast) but it was based on [Climate](https://github.com/thephpleague/climate)  by [Joe Tannenbaum](https://github.com/joetannenbaum). For feature requests and suggestions
you could consider sending me an e-mail.

## License

Redbox-cli is released under the MIT public license.

[LICENSE](LICENSE.md)
 
  