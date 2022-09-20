<?php

namespace App\Poscredit\Shared\Serializer;

use App\Poscredit\Shared\ValueObject\AbstractValueObject;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;

class ValueObjectNormalizer implements ContextAwareNormalizerInterface
{
    public function normalize($object, string $format = null, array $context = [])
    {
        return (string) $object;
    }

    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        return $data instanceof AbstractValueObject;
    }
}