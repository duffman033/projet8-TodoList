<?php

namespace App\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

class RolesTransformer implements DataTransformerInterface
{
    public function transform($value): mixed
    {
        return count($value) ? $value[0] : null;
    }

    public function reverseTransform($value): array
    {
        return [$value];
    }
}