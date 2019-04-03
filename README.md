# Perfect Oblivion - Payload
### A domain payload implementation for Laravel/PHP
[![Latest Stable Version](https://poser.pugx.org/perfect-oblivion/payload/version)](https://packagist.org/packages/perfect-oblivion/payload)
[![Build Status](https://img.shields.io/travis/perfect-oblivion/payload/master.svg)](https://travis-ci.org/perfect-oblivion/payload)
[![Quality Score](https://img.shields.io/scrutinizer/g/perfect-oblivion/payload.svg)](https://scrutinizer-ci.com/g/perfect-oblivion/payload)
[![Total Downloads](https://poser.pugx.org/perfect-oblivion/payload/downloads)](https://packagist.org/packages/perfect-oblivion/payload)

![Perfect Oblivion](https://res.cloudinary.com/phpstage/image/upload/v1554128207/img/Oblivion.png "Perfect Oblivion")

### Disclaimer
The packages under the PerfectOblivion namespace exist to provide some basic functionality that I prefer not to replicate from scratch in every project. Nothing groundbreaking here.

The payload package provides a simple domain payload object that can encapsulate a result from a controller, service class, etc., so that it can be easily passed to a response.

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
Currently, the package provides a Payload class and a couple of Laravel ResponseFactory macros to help convert the Payload into either a json response or return a view with the payload data.
For users not using Laravel, there are a handful of methods that allow you to retrieve the Payload data easily so that it can be used further.

The provided example below, utilizes a Payload from within a Controller class. The ```all()``` method returns the Payload output, messages, and status, as an array, so that each of those parts are easily accessible to be used as needed.

```php
public function index(Request $request)
{
    $users = \App\Models\User::get();

    $payload = Payload::instance()
                    ->setOutput($users)
                    ->setMessages(['success' => 'Operation successful!'])
                    ->setStatus($payload::STATUS_OK);

    return $payload->all();
    // [
    //     'output' => [
    //         [
    //             'id' => 1,
    //             'name' => 'John Doe'
    //         ],
    //         [
    //             'id' => 2,
    //             'name' => 'Jane Doe'
    //         ],
    //         [
    //             'id' => 3,
    //             'name' => 'Sally Johnson'
    //         ]
    //     ],
    //     'messages' => [
    //         'success' => 'Operation successful!'
    //     ],
    //     'status' => 200
    // ]
}
```
Messages and status are optional. You can use these values in the response you return, however you wish.

> Using the ```all()``` method, if the provided output can be converted to an array automatically, it will. For instance, in Laravel, you may pass a collection of User models to ```setOutput()```. In this case, the ```all()``` method will convert the collection of User objects to an array of arrays. To retrieve the raw original data that was provided to ```setOutput()```, call the ```getRawOutput()``` method.

The following methods are available to retrieve information from the Payload object:
```php

    /**
     * Get the status of the payload.
     */
    public function getStatus(): int;

    /**
     * Get messages array from the payload.
     */
    public function getMessages(): array;

    /**
     * Get the Payload output.
     */
    public function getOutput(): array;

    /**
     * Get the raw Payload output.
     *
     * @return mixed
     */
    public function getRawOutput();

    /**
     * Get the wrapped Payload output.
     */
    public function getWrappedOutput(): array;

    /**
     * Get the wrapper for the output.
     */
    public function getOutputWrapper(): string;

    /**
     * Get the wrapper for messages.
     */
    public function getMessagesWrapper(): string;

    /**
     * Return all of the components of the payload in array format.
     */
    public function all(): array;
```

### Response Helpers / Laravel
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
> Note: When using these helpers, the payload's status code will also be sent with the response.

The other helper is ```viewWithPayload()```:
```php
response()->viewWithPayload('dashboard', $payload, 'payload');
```
The third argument to ```viewWithPayload()``` is the string that you will use to refer to the data in your view. By default, 'payload' is used. Using the following:
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
