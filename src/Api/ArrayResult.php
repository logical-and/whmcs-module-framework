<?php

namespace WHMCS\Module\Framework\Api;

use ArrayAccess;
use Axelarge\ArrayTools\Arr;
use Countable;
use Iterator;

class ArrayResult implements ArrayAccess, Iterator, Countable
{

    protected $data = [];
    protected $result = [];

    protected $apiMethod = '';
    protected $apiArgs = [];

    public function __construct(array $data, $resultPath = '', $apiMethod = '', array $apiArgs = [])
    {
        $this->data = $data;
        $this->apiMethod = $apiMethod;
        $this->apiArgs = $apiArgs;

        $resultPath = (string) $resultPath;
        if ($resultPath) {
            $result = Arr::getNested($data, $resultPath);
            if (!is_null($result)) {
                $this->result = $result;
            }
        }
        else {
            $this->result = $data;
        }
    }

    // Validate

    public function isLoaded()
    {
        return !empty($this->result);
    }

    public function isValid($key)
    {
        // Key=value
        if (false !== strpos($key, '=')) {
            list($key, $valueToCheck) = explode('=', $key);
        }

        $foundValue = $this->offsetGet($key);

        if (is_null($foundValue) or (isset($valueToCheck) and $valueToCheck != $foundValue)) {
            return false;
        }

        return true;
    }

    public function validate(
        $key,
        $message = 'Wrong response - %s (request - "%s", args - %s)',
        $exceptionClass = ResponseException::class
    ) {

        if (!$this->isValid($key)) {
            throw new $exceptionClass(sprintf($message, json_encode($this->data), $this->apiMethod,
                json_encode($this->apiArgs)));
        }

        return $this;
    }

    // Accessors

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return !is_null($this->offsetGet($offset));
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($key)
    {
        $dataPrefix = 'data.';
        $key = (string) $key;

        // Direct data request
        if (0 === strpos('data.', $key)) {
            $dataset = $this->data;
            $key = substr($key, 0, strlen($dataPrefix));
        }
        // Result request
        else {
            $dataset = $this->result;
        }

        // Use lowercase before since in whmcs api everything in lowercase
        foreach ([strtolower($key), $key] as $key) {
            // Simple key
            if (false === strpos($key, '.')) {
                if (isset($dataset[ $key ])) {
                    $result = $dataset[ $key ];
                    break;
                }
            }
            // Nested key
            else {
                $result = Arr::getNested($dataset, $key);
                if (!is_null($result)) {
                    break;
                }
            }
        }

        if (isset($result)) {
            if (is_array($result)) {
                return new static($result, '', $this->apiMethod, $this->apiArgs);
            }
            else {
                return $result;
            }
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        throw new \InvalidArgumentException('Not implemented!');
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        throw new \InvalidArgumentException('Not implemented!');
    }

    // Misc

    public function getApiMethod()
    {
        return $this->apiMethod;
    }

    public function getApiArgs()
    {
        return $this->apiArgs;
    }

    public function __toString()
    {
        return json_encode($this->result ? $this->result : $this->data);
    }

    // Iterator

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        return $this->offsetGet($this->key());
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        return next($this->result);
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return key($this->result);
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        return null !== key($this->result);
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        reset($this->result);
    }

    /**
     * Count elements of an object
     *
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count()
    {
        return count($this->result);
    }
}
