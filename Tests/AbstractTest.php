<?php

namespace FDevs\Bridge\Locale\Tests;

use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

abstract class AbstractTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param string $class
     * @param array  $data
     *
     * @return object
     */
    public static function fromArray($class, array $data)
    {
        $normalizer = new ObjectNormalizer();

        return $normalizer->denormalize($data, $class);
    }
}
