<?php

namespace WHMCS\Module\Framework;

use
    /** @noinspection PhpUndefinedNamespaceInspection */
    /** @noinspection PhpUndefinedClassInspection */
    Illuminate\Database\Connection;

/** @noinspection PhpUndefinedClassInspection */
class ConnectionClone extends Connection
{
    public static function constructClone(
        /** @noinspection PhpUndefinedClassInspection */
        Connection $conn)
    {
        return new static($conn->getPdo(), $conn->getDatabaseName(), $conn->getTablePrefix(), $conn->config);
    }
}
