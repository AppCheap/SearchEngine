<?php

namespace Appcheap\SearchEngine\Service\Engine\Models;

class Type
{
    public const STRING = 'string';
    public const STRING_ARRAY = 'string[]';
    public const INT32 = 'int32';
    public const INT32_ARRAY = 'int32[]';
    public const INT64 = 'int64';
    public const INT64_ARRAY = 'int64[]';
    public const FLOAT = 'float';
    public const FLOAT_ARRAY = 'float[]';
    public const BOOL = 'bool';
    public const BOOL_ARRAY = 'bool[]';
    public const GEOPOINT = 'geopoint';
    public const GEOPOINT_ARRAY = 'geopoint[]';
    public const OBJECT = 'object';
    public const OBJECT_ARRAY = 'object[]';
    public const STRING_STAR = 'string*';
    public const IMAGE = 'image';
    public const AUTO = 'auto';

    /**
     * Get all supported types.
     *
     * @return array An array of all supported types.
     */
    public static function getAllTypes(): array
    {
        return [
            self::STRING,
            self::STRING_ARRAY,
            self::INT32,
            self::INT32_ARRAY,
            self::INT64,
            self::INT64_ARRAY,
            self::FLOAT,
            self::FLOAT_ARRAY,
            self::BOOL,
            self::BOOL_ARRAY,
            self::GEOPOINT,
            self::GEOPOINT_ARRAY,
            self::OBJECT,
            self::OBJECT_ARRAY,
            self::STRING_STAR,
            self::IMAGE,
            self::AUTO,
        ];
    }
}
