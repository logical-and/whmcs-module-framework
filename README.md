# WHMCS Module Framework

## How to use:
`1.` Create addon/plugin inside WHMCS modules directory, for example "plugin-name"

`2.` Create file "plugin-name.php" inside "plugin-name" directory
```php
return Addon::registerModuleByFile(__FILE__,
   Addon::configBuilder()
   ->setName('My Plugin Friendly Name')
   ->setDescription('description')
   ->setAuthor('And')
   ->addField(FieldConfigBuilder::dropdown('choice', 'Type')->addOption('One and only option', 'option1'))
   ->build());
```
`3.` Create "hooks.php" inside "plugin-name" directory

```php
ModuleHooks::registerHooks([
    YourHookClass::class,
    CallbackHook::createCallback('eventName', 0, function() {})
]);
```

or 
```php
CallbackHook::attachCallback('InvoiceCreation', 0, function() {
    echo $this->getModule()->getId();
    echo $this->view('smarty.tpl', ['var' => 'value']);
});
CallbackHook::attachCallback(Invoice\InvoiceCreated::KEY, 0, function() {
    // Do your things here
});
```

## Api requestor:

```php
$orders = APIFactory::orders()->getOrders($userId, 'Pending');
// No result, most cases is error
if (!$orders->isLoaded()) {
    return;
}
```

```php
APIFactory::billing()
->addCredit($userId, $invoice['credit'],
    sprintf('Refund of customers credit for "%s" because of order "%s" cancellation (Blazing Dashboard Proxy)',
        $invoice['credit'], $order['id']))
->validate('result=success')
```

### Methods in response to use:
* **#isLoaded**() - false if error, or wrong response; each response validates by data path defined in request methods, for example for getInvoices it is **invoices.invoice** 
* **#validate**(key, messageForException, exceptionClass = ResponseException) - key can be path.with.dots
* **#getApiMethod**()
* **#getApiArgs**()
* **#__toString**() - json encoded data

Response is valid array, except you can use to get values path.with.dots (nested array path). Even more convenience - path is case-insensitive
One thing - you can change (set/unset) values in array.

Response by default relative by data container (for getInvoices it is **invoices.invoice**), but if you want to get data from root you should use path *data.rootResponseValue*

## Page Hooks

Methods to inject custom content to any page. Usage:

```php
AnyPageHook::buildInstance()->setPosition(AnyPageHook::POSITION_HEAD_BOTTOM)->setCodeCallback(function($vars) {
    $page = $vars['templatefile'];

    return "<meta page-template=\"$page\" />";
})->apply()
```