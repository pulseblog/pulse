<?php namespace Pulse\Base;

use TestCase;
use Mockery as m;

class DomainObjectTest extends TestCase
{
    public function testShouldGetNewErrors()
    {
        // Set
        $obj = new _stubDomainObject;
        $messageBagClass = 'Illuminate\Support\MessageBag';

        // Assertion
        $this->assertInstanceOf($messageBagClass, $obj->errors());
    }

    public function testShouldGetExistentErrors()
    {
        // Set
        $messageBag = m::mock('Illuminate\Support\MessageBag');
        $obj = new _stubDomainObject;
        $obj->errors = $messageBag;
        $messageBagClass = 'Illuminate\Support\MessageBag';

        // Assertion
        $this->assertEquals($messageBag, $obj->errors());
    }

    public function testShouldImplementJsonSerializable()
    {
        // Set
        $obj = new _stubDomainObject;
        $obj->name = 'Test Object';

        // Assertion
        $this->assertEquals(
            ['name'=>'Test Object'],
            $obj->jsonSerialize()
        );
    }
}

class _stubDomainObject extends DomainObject {}
