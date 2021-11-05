# Introduction

The whole concepts of arguments are divided in two subjects ***options*** and ***operations***. 
Where operations could be custom actions like **login** or **download** they are not mandatory to add options to your project.

## Adding options

```php 
<?php

use Redbox\Cli\Arguments\Option;
use Redbox\Cli\Cli;

$cli = new Cli;

$cli->arguments->addOption(
    'user',
    'u',
    Option::OPTION_OPTIONAL,
    "Username to log in with.");

```

## Displaying the usage screen

```php 
<?php


use Redbox\Cli\Arguments\Option;
use Redbox\Cli\Cli;

$cli = new Cli;

/**
 * This is optional.
 */
$cli->setDescription("Showcase of the usage function.");

/**
 * Add an option that we can show.
 */
$cli->arguments->addOption(
    'user',
    'u',
    Option::OPTION_OPTIONAL,
    "Username to log in with.");

$cli->arguments->usage();
```

### Outputs
```bash

 usage.php - Showcase of the usage function.

 usage: usage.php default [-u, --user=user]

 Options:

 usage.php default -u, --User=User       Username to log in with.
```