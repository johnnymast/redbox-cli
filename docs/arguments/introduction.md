# Introduction

The whole concepts of arguments are divided in two subjects ***options*** and ***operations***. 
Where operations could be custom actions like **login** or **download** they are not mandatory to add options to your application.

Let's start easy by just adding to your application.

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
    "Username to log in with."
);

```
The code above will add an optional option. 

### Option flags

You can use the following option flags to make your options optional/required or a flag by using the no value type.

`Option::OPTION_REQUIRED`

:   Using this flag means the option is required.

`Option::OPTION_OPTIONAL`

:   Using this flag means this option is not required.

`Option::OPTION_NO_VALUE`

:   Using this flag means the option has no default value and is used as initiator.


## Getting the input from the command line 

```php 
<?php

/**
 * Run this example with argument -u=johnny
 */
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

$cli->arguments->parse();
$user = $cli->arguments->get("user");

echo "You provided username {$user}\n";


```

## Displaying the usage screen
 
Note about setDiscription
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
    "Username to log in with."
);

$cli->arguments->usage();
```

### Outputs
```bash

 usage.php - Showcase of the usage function.

 usage: usage.php default [-u, --user=user]

 Options:

 usage.php default -u, --User=User       Username to log in with.
```