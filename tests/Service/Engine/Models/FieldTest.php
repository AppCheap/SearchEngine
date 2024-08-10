<?php

use PHPUnit\Framework\TestCase;
use Appcheap\SearchEngine\Service\Engine\Models\Field;
use Appcheap\SearchEngine\App\Exception\FieldException;

class FieldTest extends TestCase
{
    public function testFieldCreationWithValidData()
    {
        $data = [
            'name' => 'title',
            'type' => 'string',
            'facet' => true,
            'optional' => false,
            'index' => true,
            'store' => true,
            'sort' => true,
            'infix' => false,
            'locale' => 'en_US',
            'num_dim' => 3,
            'vec_dist' => 'euclidean',
            'reference' => 'other_field',
            'range_index' => true,
            'stem' => true,
        ];

        $field = Field::create($data);

        foreach ($data as $key => $value) {
            $this->assertEquals($value, $field->$key);
        }
    }

    public function testFieldCreationWithInvalidData()
    {
        $this->expectException(FieldException::class);
        $this->expectExceptionMessage('Invalid field: invalid_field');

        $data = [
            'name' => 'title',
            'type' => 'string',
            'invalid_field' => 'value',
        ];

        Field::create($data);
    }

    public function testMagicGetMethod()
    {
        $data = [
            'name' => 'title',
            'type' => 'string',
        ];

        $field = Field::create($data);

        $this->assertEquals('title', $field->name);
        $this->assertEquals('string', $field->type);

        $this->expectException(FieldException::class);
        $this->expectExceptionMessage('Property non_existing_property does not exist');
        $field->non_existing_property;
    }

    public function testMagicSetMethod()
    {
        $data = [
            'name' => 'title',
            'type' => 'string',
        ];

        $field = Field::create($data);

        $field->name = 'new_title';
        $this->assertEquals('new_title', $field->name);

        $this->expectException(FieldException::class);
        $this->expectExceptionMessage('Property non_existing_property does not exist');
        $field->non_existing_property = 'value';
    }

    public function testValidateWithValidData()
    {
        $data = [
            'name' => 'title',
            'type' => 'string',
            'facet' => true,
            'optional' => false,
            'index' => true,
            'store' => true,
            'sort' => true,
            'infix' => false,
            'locale' => 'en_US',
            'num_dim' => 3,
            'vec_dist' => 'euclidean',
            'reference' => 'other_field',
            'range_index' => true,
            'stem' => true,
        ];

        Field::validate($data);
        $this->assertTrue(true); // If no exception is thrown, the test passes
    }

    public function testValidateWithInvalidData()
    {
        $this->expectException(FieldException::class);
        $this->expectExceptionMessage('Invalid field: invalid_field');

        $data = [
            'name' => 'title',
            'type' => 'string',
            'invalid_field' => 'value',
        ];

        Field::validate($data);
    }

    public function testValidateWithMissingRequiredField()
    {
        $this->expectException(FieldException::class);
        $this->expectExceptionMessage('Field: name is required');

        $data = [
            'type' => 'string',
        ];

        Field::validate($data);
    }

    public function testValidateWithInvalidFieldType()
    {
        $this->expectException(FieldException::class);
        $this->expectExceptionMessage('Invalid value for field: facet');

        $data = [
            'name' => 'title',
            'type' => 'string',
            'facet' => 'not_a_boolean',
        ];

        Field::validate($data);
    }
}