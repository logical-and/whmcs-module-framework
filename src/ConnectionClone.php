<?php

namespace WHMCS\Module\Framework;

use
    /** @noinspection PhpUndefinedNamespaceInspection */
    /** @noinspection PhpUndefinedClassInspection */
    Illuminate\Database\Connection;
use ReflectionObject;

/** @noinspection PhpUndefinedClassInspection */
class ConnectionClone extends Connection
{
    public static function constructClone(
        /** @noinspection PhpUndefinedClassInspection */
        Connection $conn)
    {
        $clonedConn = new static($conn->getPdo(), $conn->getDatabaseName(), $conn->getTablePrefix(), $conn->config);

        $reflObj = new ReflectionObject($conn);
        foreach ($reflObj->getProperties() as $reflProp) {
            // Works fine since Connection has only protected elements
            $clonedConn->{$reflProp->getName()} = $conn->{$reflProp->getName()};
        }

        return $clonedConn;
    }
}
