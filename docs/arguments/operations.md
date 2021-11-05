Operations are usefully if your application supports more than one default action. Let's say you are building 
a beautiful ftp client, and you want to give your users the option to upload or download a file from a server.

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






