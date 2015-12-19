## 1.1.1 2015-19-12

* Updated the CHANGELOG.md to also contain the missing 1.0 changelog entry. fixed #3
* Added a new line to Redbox\Cli\Arguments::usage() so it would look better. fixed #2 
* Added Redbox\Cli\Manager::hasDefaultValue() so you know if the default value was set #fixed #5
* Removed the comment about default arguments and if its a good thing in Redbox\Cli\Arguments\Parser::parse()
* Changed the comments in examples/defaultvalue.php and examples/default.php to mimic the testcase better.
* Added examples/hasdefaultvalue.php to show the Redbox\Cli\Manager::hasDefaultValue() fature.
* redbox\Cli\Arguments::get() now returns false if the argument is unknown.
* Removed TestBase.php as it was an unused class.
* Added more tests, also for the Manager class.

## 1.1 - 2015-13-12 

This is it the first non zero release of redbox-cli is here.

## 1.0 - 2015-12-12

This is version 1.0. I'm committing all over the place because i didn't add any tests yet. This is soon to change.
As with any software its better to wait for the 1.1 release.