If you wish to posh up the output of your application of the command line you now can. Since the release of version 1.5 Redbox-cli 
now supports colors for the command line (Windows included).

Supported colors:

* red
* green
* blue
* white
* black
* yellow
* magenta
* cyan

## Foreground colors 

The text for the color functions are optional this makes them chainable. There is an example:

```php
<?php
$cli->red('This text is now red');
$cli->red()->write('Also an other way to ')
```

## Background colors

All supported colors have a "Background" suffix as well allowing you use background colors in your text as well. 
And just like the foreground colors the background colors are chainable as well. 

```php
<?php
$cli->redBackground('This background color red.');
$cli->redBackground()->write('Also an other way to get a red background color.');
```


