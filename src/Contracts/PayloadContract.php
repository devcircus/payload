<?php

namespace PerfectOblivion\Payload\Contracts;

interface PayloadContract extends Status
{
    /**
     * Set the Payload status.
     *
     * @param  int  $status
     */
    public function setStatus(int $status): PayloadContract;

    /**
     * Get the status of the payload.
     */
    public function getStatus(): int;

    /**
     * Set the Payload messages.
     *
     * @param  array  $output
     */
    public function setMessages(array $messages): PayloadContract;

    /**
     * Get messages array from the payload.
     */
    public function getMessages(): array;

    /**
     * Set the Payload output.
     *
     * @param  mixed  $output
     * @param  string|null  $wrapper
     */
    public function setOutput($output, ? string $wrapper = null): PayloadContract;

    /**
     * Get the Payload output.
     */
    public function getOutput(): array;

    /**
     * Get the wrapped Payload output.
     */
    public function getWrappedOutput(): array;

    /**
     * Get the wrapper for the output.
     */
    public function getOutputWrapper(): string;

    /**
     * Get the wrapper for messages.
     */
    public function getMessagesWrapper(): string;

    /**
     * Prepare the Payload object to be used in a response.
     */
    public function forResponse(): array;
}
