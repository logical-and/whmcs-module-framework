# WHMCS Module Framework

## How to use:
`1.` Create addon/plugin inside WHMCS modules directory, for example "plugin-name"

`2.` Create file "plugin-name.php" inside "plugin-name" directory
```php
return Module::registerModuleByFile(__FILE__, [
    'name'        => 'Plugin Name',
    'description' => 'Plugin description',
    'version'     => '1.0',
    'author'      => 'And <and@e.mail>'
]);
```
`3.` Create "hooks.php" inside "plugin-name" directory

```php
ClassesHooks::registerHooks([
    YourHookClass::class
]);
```

or 
```php
CallbackHook::attachCallback('InvoiceCreation', 0, function() {
    // Do your things here
});
CallbackHook::attachCallback(Invoice\InvoiceCreated::KEY, 0, function() {
    // Do your things here
});
```
