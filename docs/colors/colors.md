## Colors

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

Examples for using text colors. 

```php
<?php
$cli->red('This text is now red');
$cli->red()->write('Also an other way to ')
```

The text for the color functions are optional this makes them chainable. The same also goes for the background colors that are available to you.
Here is an example.


```php
<?php
$cli->redBackground('This background color red.');
$cli->redBackground()->write('Also an other way to get a red background color.');
```


| Name   |  foreground color  | background function  | 
|---|---|---|
|   red |  red([string $string = '']) | redBackground([string $string = ''])|
|  green |  green([string $string = ''])  |   greenBackground([string $string = '']) |
|  blue | blue([string $string = ''])  | blueBackground([string $string = ''])  |
|  white | white([string $string = ''])  | whiteBackground([string $string = ''])  |
|  black | black([string $string = ''])  | blackBackground([string $string = ''])  |
|  yellow | yellow([string $string = ''])  | yellowBackground([string $string = ''])  |
|  magenta | magenta([string $string = ''])  | magentaBackground([string $string = ''])  |
|  cyan | cyan([string $string = ''])  | cyanBackground([string $string = ''])  |


* @method \Redbox\Cli\Output\OutputBuffer reset()

