<?php

namespace Application\Logger;

use Psr\Log\InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Stringable;

/**
 *
 */
class Logger implements LoggerInterface
{

    /** @var array */
    private $logConfig;

    /**
     * @param array $logConfig
     */
    public function setLogConfig(array $logConfig): void
    {
        $this->logConfig = $logConfig;
    }


    /**
     * System is unusable.
     *
     * @param string|Stringable $message
     * @param mixed[]           $context
     *
     * @return void
     */
    public function emergency(string|Stringable $message, array $context = []): void
    {
        if ($this->logConfig['emergency'] == true) {
            $this->write($message, 'error');
        }
    }

    /**
     * Action must be taken immediately.
     *
     * Example: Entire website down, database unavailable, etc. This should
     * trigger the SMS alerts and wake you up.
     *
     * @param string|Stringable $message
     * @param mixed[]           $context
     *
     * @return void
     */
    public function alert(string|Stringable $message, array $context = []): void
    {
        if ($this->logConfig['alert'] == true) {
            $this->write($message, 'error');
        }
    }

    /**
     * Critical conditions.
     *
     * Example: Application component unavailable, unexpected exception.
     *
     * @param string|Stringable $message
     * @param mixed[]           $context
     *
     * @return void
     */
    public function critical(string|Stringable $message, array $context = []): void
    {
        if ($this->logConfig['critical'] == true) {
            $this->write($message, 'error');
        }
    }

    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     *
     * @param string|Stringable $message
     * @param mixed[]           $context
     *
     * @return void
     */
    public function error(string|Stringable $message, array $context = []): void
    {
        if ($this->logConfig['error'] == true) {
            $this->write($message, 'error');
        }
    }

    /**
     * Exceptional occurrences that are not errors.
     *
     * Example: Use of deprecated APIs, poor use of an API, undesirable things
     * that are not necessarily wrong.
     *
     * @param string|Stringable $message
     * @param mixed[]           $context
     *
     * @return void
     */
    public function warning(string|Stringable $message, array $context = []): void
    {
        if ($this->logConfig['warning'] == true) {
            $this->write($message, 'warning');
        }
    }

    /**
     * Normal but significant events.
     *
     * @param string|Stringable $message
     * @param mixed[]           $context
     *
     * @return void
     */
    public function notice(string|Stringable $message, array $context = []): void
    {
        if ($this->logConfig['notice'] == true) {
            $this->write($message, 'warning');
        }
    }

    /**
     * Interesting events.
     *
     * Example: User logs in, SQL logs.
     *
     * @param string|Stringable $message
     * @param mixed[]           $context
     *
     * @return void
     */
    public function info(string|Stringable $message, array $context = []): void
    {
        if ($this->logConfig['info'] == true) {
            $this->write($message, 'warning');
        }
    }

    /**
     * Detailed debug information.
     *
     * @param string|Stringable $message
     * @param mixed[]           $context
     *
     * @return void
     */
    public function debug(string|Stringable $message, array $context = []): void
    {
        if ($this->logConfig['debug'] == true) {
            $this->write($message, 'error');
        }
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed             $level
     * @param string|Stringable $message
     * @param mixed[]           $context
     *
     * @return void
     *
     * @throws InvalidArgumentException
     */
    public function log($level, string|Stringable $message, array $context = []): void
    {
        if ($this->logConfig['log'] == true) {
            $this->write($message, 'warning');
        }
    }

    /**
     * @param string $message
     * @param string $mode
     */
    private function write($message, $mode)
    {
        $filename = $this->logConfig['path'] . '/' . date("Y-m") . '/' . $mode . '.log';
        if (!is_dir(dirname($filename))) {
            mkdir(dirname($filename) . '/', 0777, true);
        }
        $message = date("Y-m-d H:i:s") . $message . PHP_EOL;

        file_put_contents($filename, $message, FILE_APPEND | LOCK_EX);
    }
}
