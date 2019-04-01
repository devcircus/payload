<?php

namespace PerfectOblivion\Payload\Contracts;

interface PayloadContract extends Status
{
    /**
     * Set the Payload status.
     *
     * @param  string  $status
     *
     * @return $this
     */
    public function setStatus($status);

    /**
     * Get the status of the payload.
     *
     * @return string
     */
    public function getStatus();

    /**
     * Set the Payload output.
     *
     * @param  mixed  $output
     * @param  string|null  $wrapper
     *
     * @return $this
     */
    public function setOutput($output, ? string $wrapper = null);

    /**
     * Get the Payload output.
     *
     * @return array
     */
    public function getOutput();

    /**
     * Get the wrapped Payload output.
     *
     * @return array
     */
    public function getWrappedOutput();

    /**
     * Set the Payload messages.
     *
     * @param  array  $output
     *
     * @return $this
     */
    public function setMessages(array $messages);

    /**
     * Get messages array from the payload.
     *
     * @return array
     */
    public function getMessages();

    /**
     * Get the wrapper for the output.
     *
     * @return string
     */
    public function getOutputWrapper();

    /**
     * Get the wrapper for messages.
     *
     * @return string
     */
    public function getMessagesWrapper();
}
