[![Build Status](https://travis-ci.com/Solizion/php-baselinker.svg?branch=master)](https://travis-ci.com/Solizion/php-baselinker)
# PHP BaseLinker API 
php-baselinker is a PHP library for accessing the [BaseLinker](https://baselinker.com/) service.

Currently **the library has BETA status**

Library not implement each of method from BaseLinker API [Documentation](https://api.baselinker.com/) yet.

## Installation
To install php-baselinker, [install Composer](https://getcomposer.org/download/) and issue the following command:

```
composer require solizion/php-baselinker
```

## Usage

Create a client object and pass as parameters api url and  generated api key.
To generate an api key, you must first have an existing baselinker account, and then go to "My account" -> "API" -> type name of application and click "Generate token".

```PHP
use BaselinkerClient\Client;

$apiUrl = "https://api.baselinker.com/connector.php";
$apiKey = "verySecretApiKey"

$client = new Client($apiUrl, $apiKey);
```

### Example

Get logs kind of "create new order", "change order status" from the journal.

```PHP
use BaselinkerClient\Client;
use BaselinkerClient\Journal\GetJournalListParameters;

$apiUrl = "https://api.baselinker.com/connector.php";
$apiKey = "verySecretApiKey"

$client = new Client($apiUrl, $apiKey);

$parameters = new GetJournalListParameters(
    1, // last_log_id
    [
        GetJournalListParameters::CREATE_ORDER,
        GetJournalListParameters::REMOVE_ORDER,
    ], // log_types
    null, // order_id
);

$journal = $client->getJournalList($parameters);
```

## Errors

BaseLinker return field "status" with values "SUCCESS" or "ERROR".

When status is "ERROR" then fields `error_message` and `error_code` are added to the response.

## Developed methods

Name           | Description
-------------- | -----------
GetJournalList | Get list of events

## Versioning

Versioning is based on [semver](https://semver.org/).

New version is release by a new tag.

## Licence

This library is distributed under the BSD 3 Licence, see LICENSE for more information.

## Contributing

Authors of this library are Kamil Ciekalski, Dawid Miklas and Marcisz Szczot

If you want to help with development it - **fork me!**
