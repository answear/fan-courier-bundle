# FanCourier bundle

FanCourier integration for Symfony.  
Documentation of the API can be found here: https://github.com/FAN-Courier/API-Docs

## Installation

* install with Composer

```
composer require answear/fan-courier-bundle
```

`Answear\FanCourierBundle\AnswearFanCourier::class => ['all' => true],`  
should be added automatically to your `config/bundles.php` file by Symfony Flex.

## Setup

```yaml
# config/packages/answear_fancourier.yaml
answear_fan_courier:
    clientId: yourClientId
    username: yourUsername
    password: yourPassword
    apiUrl: apiUrl
    logger: customLogger #default: null
```
Logger service must implement Psr\Log\LoggerInterface interface.

## Usage

### TODO

Final notes
------------

Feel free to open pull requests with new features, improvements or bug fixes. The Answear team will be grateful for any comments.

