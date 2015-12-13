[![Build Status](https://travis-ci.org/johnnymast/redbox-cli.svg)](https://travis-ci.org/johnnymast/redbox-cli) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/johnnymast/redbox-cli/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/johnnymast/redbox-cli/?branch=master) [![Code Coverage](https://scrutinizer-ci.com/g/johnnymast/redbox-cli/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/johnnymast/redbox-cli/?branch=master)


# redbox-cli
This is a command line parser based on [Climate](https://github.com/thephpleague/climate)  by [Joe Tannenbaum](https://github.com/joetannenbaum). We share a lot of similarities but i desided to take the getopt route and downgrade the number of lines in the code by 1/4 of the original code.


## Howto use it
Look in the examples folder for basic examples of how to use the code.

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

I was about to write a load of unit tests. There is a litle but on phpunit <= 5.0. Apearently in later versions you could debug commandline arguments but with the current version required in composer.json (Thats 4.6) we currently cannot debug commandline arugments.
I am really sorry about this BUT you can run the tests from the [examples/](https://github.com/johnnymast/redbox-cli/tree/master/examples) directory to see if the package fits your needs.

 

## Author

This package is created and maintained by [Johnny Mast](https://github.com/johnnymast) but it was based on [Climate](https://github.com/thephpleague/climate)  by [Joe Tannenbaum](https://github.com/joetannenbaum). For feature requests and suggestions
you could consider sending me an e-mail.

## License

Cli is released under the MIT public license.

<https://github.com/johnnymast/redbox-cli/blob/master/LICENSE.md>
 
