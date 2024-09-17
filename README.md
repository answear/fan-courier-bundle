# FanCourier bundle

FanCourier integration for Symfony.  
Documentation of the API can be found here: https://www.fancourier.ro/wp-content/uploads/2023/07/EN_FANCourier_API-2.0-160523.pdf

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
    username: yourUsername
    password: yourPassword
    apiUrl: apiUrl
    logger: customLogger #default: null
```

Logger service must implement Psr\Log\LoggerInterface interface.

## Usage

### Get pickup points

```php
namespace App\Service\PickupPointsImporter;

use Answear\FanCourierBundle\Service\PickupPointService;

class FanCourierImport
{
    public function __construct(
        private PickupPointService $pickupPointService,
    ) {
    }

    /**
     * @return PickupPointDTO[]
     */
    public function getPickupPoints(): array
    {
        return $this->pickupPointService->getAll();
    }
}

```

Above `getPickupPoints` method will return an array of `Answear\FanCourierBundle\DTO\PickupPointDTO` objects.

Final notes
------------

Feel free to open pull requests with new features, improvements or bug fixes. The Answear team will be grateful for any comments.

