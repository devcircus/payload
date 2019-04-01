<?php

namespace PerfectOblivion\Payload\Contracts;

interface PayloadContract extends Status
{
    /**
     * Set the Payload status.
     *
     * @param  int  $status
     *
     * @return \PerfectOblivion\Payload\Contracts\PayloadContract
     */
    public function setStatus(int $status): PayloadContract;

    /**
     * Get the status of the payload.
     *
     * @return int
     */
    public function getStatus(): int;

    /**
     * Set the Payload messages.
     *
     * @param  array  $output
     *
     * @return \PerfectOblivion\Payload\Contracts\PayloadContract
     */
    public function setMessages(array $messages): PayloadContract;

    /**
     * Get messages array from the payload.
     *
     * @return array
     */
    public function getMessages(): array;

    /**
     * Set the Payload output.
     *
     * @param  mixed  $output
     * @param  string|null  $wrapper
     *
     * @return \PerfectOblivion\Payload\Contracts\PayloadContract
     */
    public function setOutput($output, ? string $wrapper = null): PayloadContract;

    /**
     * Get the Payload output.
     *
     * @return array
     */
    public function getOutput(): array;

    /**
     * Get the wrapped Payload output.
     *
     * @return array
     */
    public function getWrappedOutput(): array;

    /**
     * Get the wrapper for the output.
     *
     * @return string
     */
    public function getOutputWrapper(): string;

    /**
     * Get the wrapper for messages.
     *
     * @return string
     */
    public function getMessagesWrapper(): string;

    /**
     * Prepare the Payload object to be used in a response.
     *
     * @return array
     */
    public function forResponse(): array;
}
