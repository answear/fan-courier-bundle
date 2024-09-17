<?php

declare(strict_types=1);

namespace Answear\FanCourierBundle\Serializer\Normalizer;

use Answear\FanCourierBundle\Request\RequestInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class EmptyObjectNormalizer implements NormalizerInterface
{
    public function getSupportedTypes(?string $format): array
    {
        return [
            RequestInterface::class => true,
        ];
    }

    public function normalize(mixed $object, ?string $format = null, array $context = []): array
    {
        return [];
    }

    public function supportsNormalization($data, $format = null): bool
    {
        return is_object($data) && $this->isEmptyClass($data);
    }

    private function isEmptyClass($object): bool
    {
        $reflectionClass = new \ReflectionClass($object);

        return empty($reflectionClass->getProperties());
    }
}
