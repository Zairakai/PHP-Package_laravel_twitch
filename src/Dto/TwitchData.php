<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto;

use ReflectionClass;
use ReflectionNamedType;
use ReflectionProperty;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Zairakai\LaravelTwitch\Support\ScalarCoercion;

/**
 * Base class of every DTO of the package: it hands back what Twitch sent, structured and typed.
 *
 * What Twitch sends is not always typed the way the DTO declares it: a boolean can come as "true", "false", "1" or
 * "0", a number as a string. PHP would read the string "false" as true, so the values are converted here, before the
 * DTO is built, for the properties declared `bool`, `int` or `float` (nullable or not).
 */
abstract class TwitchData extends Data
{
    private const array SCALARS = [
        'bool',
        'int',
        'float',
    ];

    /**
     * @var array<class-string, list<array{names: list<string>, type: 'bool'|'int'|'float'}>>
     */
    private static array $scalarProperties = [];

    /**
     * @param array<mixed> $properties
     *
     * @return array<mixed>
     */
    public static function prepareForPipeline(array $properties): array
    {
        foreach (self::scalarProperties(static::class) as $scalar) {
            foreach ($scalar['names'] as $name) {
                if (array_key_exists($name, $properties)) {
                    $properties[$name] = ScalarCoercion::coerce($properties[$name], $scalar['type']);
                }
            }
        }

        return $properties;
    }

    /**
     * The keys under which the payload can carry the property: snake_case, the property name and its mapped name.
     *
     * @return list<string>
     */
    private static function inputNames(ReflectionProperty $property): array
    {
        $name  = $property->getName();
        $names = [
            strtolower((string) preg_replace(
                '/(?<!^)[A-Z]/',
                '_$0',
                $name,
            )),
            $name,
        ];

        foreach ($property->getAttributes(MapInputName::class) as $attribute) {
            $input = $attribute->newInstance()->input;

            if (
                is_string($input)
                && ! class_exists($input)
            ) {
                array_unshift($names, $input);
            }
        }

        return array_values(array_unique($names));
    }

    /**
     * @param class-string $class
     *
     * @return list<array{names: list<string>, type: 'bool'|'int'|'float'}>
     */
    private static function scalarProperties(string $class): array
    {
        if (isset(self::$scalarProperties[$class])) {
            return self::$scalarProperties[$class];
        }

        $found = [];

        foreach (new ReflectionClass($class)->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
            $type = $property->getType();

            // A union that also allows a string (string|bool) is left alone: the caller chose to keep the string.
            if (! $type instanceof ReflectionNamedType || ! in_array(
                $type->getName(),
                self::SCALARS,
                true,
            )) {
                continue;
            }

            /** @var 'bool'|'int'|'float' $scalar */
            $scalar  = $type->getName();
            $found[] = [
                'names' => self::inputNames($property),
                'type'  => $scalar,
            ];
        }

        return self::$scalarProperties[$class] = $found;
    }
}
