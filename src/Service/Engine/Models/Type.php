<?php

namespace Appcheap\SearchEngine\Service\Engine\Models;

class Type
{
    const STRING = 'string';
    const STRING_ARRAY = 'string[]';
    const INT32 = 'int32';
    const INT32_ARRAY = 'int32[]';
    const INT64 = 'int64';
    const INT64_ARRAY = 'int64[]';
    const FLOAT = 'float';
    const FLOAT_ARRAY = 'float[]';
    const BOOL = 'bool';
    const BOOL_ARRAY = 'bool[]';
    const GEOPOINT = 'geopoint';
    const GEOPOINT_ARRAY = 'geopoint[]';
    const OBJECT = 'object';
    const OBJECT_ARRAY = 'object[]';
    const STRING_STAR = 'string*';
    const IMAGE = 'image';
    const AUTO = 'auto';

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
