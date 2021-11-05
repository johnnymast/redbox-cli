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
    "Username to log in with.",
    "Default value here"
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


## Reading input

In the example below we added the user parameter as described above. But we also 
add the parse() function that allows the package to parse what was passed to the application
via the command line. The second call we added was to the get() function that allows you 
to read the value of the command line option.

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

## Usage screen

When it comes to command line arguments you also might want to show the available 
options to the users of your applications. Redbox-cli has a build in function to do 
just that. You can use the usage() function to show the available options like so:


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
???+ note "You can add an optional description to your application."

    Use ```<?php $cli->setDescription("Description here");``` to add the application description to use usage output.

Outputs something like the following:

```bash

 usage.php - Showcase of the usage function.

 usage: usage.php default [-u, --user=user]

 Options:

 usage.php default -u, --User=User       Username to log in with.
```

## Required options

When options are required but not passed to the application you might want to
show the users of your application the usage screen. This task is easy to accomplish as the package throws an Exception when a user fails to provide 
the value for a required argument. 

So putting this all together we end up with the following code.


```php 
<?php

/**
 * Run this example without any arguments.
 */
use Redbox\Cli\Arguments\Option;
use Redbox\Cli\Cli;

$cli = new Cli;

try {

    /**
     * This is optional.
     */
    $cli->setDescription("Showcase of required arguments.");

    /**
     * Add an option that we can show.
     */
    $cli->arguments->addOption(
        'user',
        'u',
        Option::OPTION_REQUIRED,
        "Username to log in with."
     );

    $cli->arguments->parse();

    $user = $cli->arguments->get('user');

    echo "You provided username {$user}\n";

} catch (\Exception) {
    $cli->arguments->usage();
}

```

If you run this example without any arguments an Exception will be thrown and the usage screen will be shown to the user of your application.