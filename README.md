# Perfect Oblivion - Payload
### A domain payload implementation for Laravel/PHP

[![Latest Version on Packagist](https://img.shields.io/packagist/v/perfect-oblivion/payload.svg)](https://packagist.org/packages/perfect-oblivion/payload)
[![Build Status](https://img.shields.io/travis/perfect-oblivion/payload/master.svg)](https://travis-ci.org/perfect-oblivion/payload)
[![Quality Score](https://img.shields.io/scrutinizer/g/perfect-oblivion/payload.svg)](https://scrutinizer-ci.com/g/perfect-oblivion/payload)
[![Total Downloads](https://img.shields.io/packagist/dt/perfect-oblivion/payload.svg)](https://packagist.org/packages/perfect-oblivion/payload)

![Perfect Oblivion](https://res.cloudinary.com/phpstage/image/upload/v1554128207/img/Oblivion.png "Perfect Oblivion")

### Disclaimer
The packages under the PerfectOblivion namespace exist to provide some basic functionality that I prefer not to replicate from scratch in every project. Nothing groundbreaking here.

The payload package provides a simple domain payload object that can package up a result from a controller, service class, etc., so that it can be easily passed to a response.

## Installation
You can install the package via composer:

```bash
composer require perfect-oblivion/payload
```

Laravel versions > 5.6.0 will automatically identify and register the service provider.
If you have this functionality disabled, add the package service provider to your config/app.php file, in the 'providers' array:
```php
'providers' => [
    //...
    PerfectOblivion\Payload\PayloadServiceProvider::class,
    //...
];
```

## Usage
Currently, the package provides a Payload class and a couple of ResponseFactory macros to help convert the Payload into either a json response or return a view with the payload data.
The provided example below, uses the Payload from within a Controller class.

```php
public function index(Request $request)
{
    $users = \App\Models\User::get();

    $payload = (new Payload)->setOutput($users)
                   ->setMessages(['success' => 'Operation successful!'])
                   ->setStatus($payload::STATUS_OK);

    return $payload->forResponse();
}
```
Messages and status are optional. You can use these values in the response you return, however you wish.

To optionally wrap the output with a key, pass the key (string) as the second argument to ```setOutput```:
```php
$payload->setOutput($users, 'data');
```
> If your payload includes 'messages', the output will automatically be wrapped with a key. If you do not provide a wrapping key, the key 'data' will be used.

### Response Helpers
If you are using Laravel, a couple of ResponseFactory macros are available to you, which makes sending payload responses, easier.
For example:
```php
$payload->setOutput($users, 'users')->setMessages(['success' => 'Operation Successful!']);
response()->jsonWithPayload($payload);
```
will yield the following structure:
```
{
    "users": [
        {
            "id": 1,
            "name": "Clayton Stone",
            "email": "clay@test.com",
            "email_verified_at": "2019-03-18 20:29:26",
            "created_at": "2019-03-18 20:29:26",
            "updated_at": "2019-03-18 20:29:26"
        },
        {
            "id": 2,
            "name": "John Doe",
            "email": "john15@gmail.com",
            "email_verified_at": "2019-03-23 18:20:11",
            "created_at": "2019-03-23 18:19:41",
            "updated_at": "2019-03-23 18:20:16"
        }
    ],
    "messages": {
        "success": "Operation successful!"
    }
}
```
The other helper is ```viewWithPayload()```:
```php
response()->viewWithPayload('dashboard', $payload, 'payload');
```
The third argument is the string that you will use to refer to the data in your view. By default, 'payload' is used. Using the following:
```php
$payload->setOutput($users, 'users')->setMessages(['success' => 'Operation Successful!']);
return response()->viewWithPayload('dashboard', $payload);
```
You would access your data as follows:
```html
<h1>{{ $payload->name }}</h1>
<span>{{ $payload->email }}</span>
```
However, you can set the third parameter in the following manner:
```php
$payload->setOutput($users, 'users')->setMessages(['success' => 'Operation Successful!']);
return response()->viewWithPayload('dashboard', $payload, 'user');
```
and access your data as follows:
```html
<h1>{{ $user->name }}</h1>
<span>{{ $user->email }}</span>
```

> If you choose not to use the helper methods, refer to the PayloadContract below for the available methods on the Payload instance:
```php
<?php

namespace PerfectOblivion\Common\Payloads\Contracts;

interface PayloadContract extends Status
{
    /**
     * Set the Payload status.
     *
     * @param  string  $status
     *
     * @return $this
     */
    public function setStatus($status);

    /**
     * Get the status of the payload.
     *
     * @return string
     */
    public function getStatus();

    /**
     * Set the Payload output.
     *
     * @param  mixed  $output
     * @param  string|null  $wrapper
     *
     * @return $this
     */
    public function setOutput($output, ? string $wrapper = null);

    /**
     * Get the Payload output.
     *
     * @return array
     */
    public function getOutput();

    /**
     * Get the unwrapped Payload output.
     *
     * @return array
     */
    public function getUnwrappedOutput();

    /**
     * Set the Payload messages.
     *
     * @param  array  $output
     *
     * @return $this
     */
    public function setMessages(array $messages);

    /**
     * Get messages array from the payload.
     *
     * @return array
     */
    public function getMessages();

    /**
     * Get the wrapper for the output.
     *
     * @return string
     */
    public function getOutputWrapper();

    /**
     * Get the wrapper for messages.
     *
     * @return string
     */
    public function getMessagesWrapper();
}
```

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email clay@phpstage.com instead of using the issue tracker.

## Roadmap

We plan to work on flexibility/configuration soon, as well as release a framework agnostic version of the package.

## Credits

- [Clayton Stone](https://github.com/devcircus)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
