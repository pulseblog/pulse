<?php namespace Pulse\Base;

use JsonSerializable;
use Illuminate\Database\Eloquent\Model;

/**
 * Base DomainObject Class
 *
 * This class represents a Domain Object that will persist into the database.
 *
 * @package  Pulse\Base
 */
abstract class DomainObject extends Model implements JsonSerializable
{
    /**
     * Error message bag
     *
     * @var \Illuminate\Support\MessageBag
     */
    public $errors;

    /**
     * Get the contents of errors attribute
     *
     * @return \Illuminate\Support\MessageBag Validation errors
     */
    public function errors()
    {
        if(! $this->errors) $this->errors = new \Illuminate\Support\MessageBag;

        return $this->errors;
    }

    /**
     * Convert the model instance to JSON.
     *
     * @return string
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
