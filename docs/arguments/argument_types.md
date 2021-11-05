# Argument types

There are three argument variants you can use:

<dl>Option::OPTION_REQUIRED</dl>
<dd>Using this flag means the option is required.</dd>

<dl>Option::OPTION_OPTIONAL</dl>
<dd>Using this flag means this option is not required.</dd>

<dl>Option::OPTION_NO_VALUE</dl>
<dd>Using this flag means the option has no default value and is used as initiator.</dd>

``` php title="bubble_sort.py"
def bubble_sort(items):
    for i in range(len(items)):
        for j in range(len(items) - 1 - i):
            if items[j] > items[j + 1]:
                items[j], items[j + 1] = items[j + 1], items[j]
```

```php
<?php
phpinfo();
```

