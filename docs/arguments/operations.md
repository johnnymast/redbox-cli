Operations are useful if your application supports more than one default action. Let's say you are building 
a beautiful FTP client, and you want to give your users the option to upload or download a file from a server.

This means you might want some options to be required with one action but maybe not with another action. This is the reason
why we have added operations to the mix. 

Setting and getting of arguments works the same as you would normally use them. In fact if you would set an argument without the use of operations the following code:


```php
$cli->arguments->get('user');
```

would alias the following code internally inside the package.

```php
$cli->arguments->getOperation("default")->get('user');
```

So let's create the scenario I mentioned above in code.


```php
<?php

use Redbox\Cli\Arguments\Option;
use Redbox\Cli\Cli;

$cli = new Cli;

try {

    /**
     * This is optional.
     */
    $cli->setDescription("My awesome ftp client.");

    $cli->arguments->registerOperation("download")
        ->addOption(
            'user',
            'u',
            Option::OPTION_REQUIRED,
            "Username to log in with."
        )
        ->addOption(
            'password',
            'p',
            Option::OPTION_REQUIRED,
            "Password to login with"
        )
        ->addOption(
            'remove-file',
            'r',
            Option::OPTION_REQUIRED,
            "The file to download."
        )
        ->addOption(
            'local-file',
            'f',
            Option::OPTION_REQUIRED,
            "Save the file here."
        );


    $cli->arguments->registerOperation("upload")
        ->addOption(
            'user',
            'u',
            Option::OPTION_REQUIRED,
            "Username to log in with."
        )
        ->addOption(
            'password',
            'p',
            Option::OPTION_REQUIRED,
            "Password to login with"
        )
        ->addOption(
            'local-file',
            'f',
            Option::OPTION_REQUIRED,
            "The file to upload."
        );

    
    $cli->arguments->parse();

} catch (\Exception) {
    $cli->arguments->usage();
}

```




