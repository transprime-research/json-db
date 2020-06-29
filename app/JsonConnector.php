<?php

namespace App;

use App\JDOs\JDO;
use Illuminate\Database\Connectors\Connector;
use Illuminate\Database\Connectors\ConnectorInterface;
use \InvalidArgumentException;

class JsonConnector extends Connector implements ConnectorInterface
{
    /**
     * Establish a database connection.
     *
     * @param array $config
     * @return \PDO|mixed
     *
     * @throws InvalidArgumentException
     */
    public function connect(array $config)
    {
        return new JDO;
    }
}
