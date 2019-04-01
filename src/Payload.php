<?php

namespace PerfectOblivion\Payload;

use ArrayAccess;
use JsonSerializable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;
use PerfectOblivion\Payload\Contracts\PayloadContract;

class Payload implements PayloadContract, ArrayAccess, JsonSerializable, Jsonable, Arrayable
{
    /** @var int */
    private $status;

    /** @var mixed */
    private $output;

    /** @var array */
    private $messages = [];

    /** @var string|null */
    private $outputWrapper = null;

    /** @var string */
    private $messagesWrapper = 'messages';

    /**
     * Set the Payload status.
     *
     * @param  int  $status
     */
    public function setStatus(int $status): PayloadContract
    {
        return tap($this, function ($instance) use ($status) {
            $instance->status = $status;
        });
    }

    /**
     * Get the status of the payload.
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * Set the Payload messages.
     *
     * @param  array  $output
     */
    public function setMessages(array $messages): PayloadContract
    {
        return tap($this, function ($instance) use ($messages) {
            $instance->messages = [$instance->messagesWrapper => $messages];
        });
    }

    /**
     * Get messages array from the payload.
     */
    public function getMessages(): array
    {
        return $this->messages;
    }

    /**
     * Set the Payload output.
     *
     * @param  mixed  $output
     * @param  string|null  $wrapper
     */
    public function setOutput($output, ? string $wrapper = null): PayloadContract
    {
        if ($wrapper) {
            $this->outputWrapper = $wrapper;
        }

        return tap($this, function ($instance) use ($output) {
            $instance->output = $output;
        });
    }

    /**
     * Get the Payload output.
     */
    public function getOutput(): array
    {
        return $this->output;
    }

    /**
     * Retrieve the Payload output and wrap it.
     * Use the outputWrapper if it is set, otherwise use 'data'.
     */
    public function getwrappedOutput(): array
    {
        return $this->outputWrapper ? [$this->outputWrapper => $this->output] : ['data' => $this->output];
    }

    /**
     * Get the wrapper for the output.
     */
    public function getOutputWrapper(): string
    {
        return $this->outputWrapper;
    }

    /**
     * Get the wrapper for the messages.
     */
    public function getMessagesWrapper(): string
    {
        return $this->messagesWrapper;
    }

    /**
     * Prepare the Payload object to be used in a response.
     */
    public function forResponse(): array
    {
        return $this->toArray();
    }

    /**
     * Dynamically retrieve attributes on the OutputItem.
     *
     * @param  string  $key
     *
     * @return mixed
     */
    public function __get($key)
    {
        return $this->output[$key];
    }

    /**
     * Convert the Payload instance to JSON.
     *
     * @param  int  $options
     *
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->jsonSerialize(), $options);
    }

    /**
     * Convert the Payload into something JSON serializable.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * Convert the Payload instance to an array.
     *
     * @return array
     */
    public function toArray()
    {
        $output = $this->outputWrapper || $this->messages ? $this->getWrappedOutput() : $this->output;

        return $this->messages ? array_merge($output, $this->messages) : $output;
    }

    /**
     * Determine if the given attribute exists.
     *
     * @param  mixed  $offset
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->$offset);
    }

    /**
     * Get the value for a given offset.
     *
     * @param  mixed  $offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->$offset;
    }

    /**
     * Set the value for a given offset.
     *
     * @param  mixed  $offset
     * @param  mixed  $value
     */
    public function offsetSet($offset, $value)
    {
        $this->$offset = $value;
    }

    /**
     * Unset the value for a given offset.
     *
     * @param  mixed  $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->$offset);
    }

    /**
     * Determine if an attribute exists on the Payload.
     *
     * @param  string  $key
     *
     * @return bool
     */
    public function __isset($key)
    {
        if (! $this->output) {
            return false;
        }

        return isset($this->output[$key]);
    }

    /**
     * Unset an attribute on the Payload.
     *
     * @param  string  $key
     */
    public function __unset($key)
    {
        if (! $this->output) {
            return;
        }

        unset($this->output[$key]);
    }

    /**
     * Convert the Payload to its string representation.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toJson();
    }
}
