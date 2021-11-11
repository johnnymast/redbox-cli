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

The colors above are functions on your Cli instance. You can pass a text with the function but 
this is not required. Let's have a look on how to write a red text to your command line. 

```php
<?php
$cli->red('This text is now red');
$cli->red()->write('Alternative method to write red text')
```

As you can see the color functions chainable, so you can mix and match with background colors.


## Background colors

All supported colors have a "Background" suffix as well allowing you use background colors in your text as well. 
And just like the foreground colors the background colors are chainable as well. 

```php
<?php
$cli->redBackground('This background color red.');
$cli->redBackground()->write('Alternative way to get a background color.');
```


## Mix and Match

You can mix and match foreground and background colors to get the desired output.

```php
<?php
$cli->red()->blueBackground('Red text blue background');
$cli->red()
    ->blueBackground()
    ->write('Alternate: Red text blue background');

```
