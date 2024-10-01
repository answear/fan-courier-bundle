<?php

declare(strict_types=1);

namespace Answear\FanCourierBundle\DTO;

use Webmozart\Assert\Assert;

readonly class AddressDTO
{
    public function __construct(
        public string $locality,
        public string $county,
        public string $street,
        public string $streetNo,
        public string $zipCode,
        public string $floor,
        public string $reference,
    ) {
    }

    /**
     * @param array{locality: string, county: string, street: string, streetNo: string, zipCode: string, floor: string, reference: string} $addressArray
     */
    public static function fromArray(array $addressArray): self
    {
        Assert::stringNotEmpty($addressArray['locality']);
        Assert::stringNotEmpty($addressArray['county']);
        Assert::stringNotEmpty($addressArray['street']);
        Assert::stringNotEmpty($addressArray['streetNo']);
        Assert::stringNotEmpty($addressArray['zipCode']);

        return new self(
            $addressArray['locality'],
            $addressArray['county'],
            $addressArray['street'],
            $addressArray['streetNo'],
            $addressArray['zipCode'],
            $addressArray['floor'],
            $addressArray['reference'],
        );
    }
}
