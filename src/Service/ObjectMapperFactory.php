<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;

class ObjectMapperFactory
{
    public static function createObjectMapper(EntityManagerInterface $entityManager): SerializerInterface
    {
        $normalizers = [
            new ObjectNormalizer(
                null,
                null,
                null,
                new ReflectionExtractor(),
                new PhpDocExtractor()
            ),
        ];

        $encoders = [new JsonEncoder()];

        return new Serializer($normalizers, $encoders);
    }
}
