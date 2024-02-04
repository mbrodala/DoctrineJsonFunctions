<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Mocks;

use Doctrine\DBAL\Driver\API\ExceptionConverter;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Driver;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Schema\AbstractSchemaManager;
use Scienta\DoctrineJsonFunctions\Tests\Mocks\Exception\NotImplemented;

/**
 * Mock class for Driver.
 */
class DriverMock implements Driver
{
    use DbalDriverCompatibility;

    /**
     * @var AbstractPlatform|null
     */
    private $_platformMock;

    /**
     * @var AbstractSchemaManager|null
     */
    private $_schemaManagerMock;

    /**
     * {@inheritdoc}
     */
    public function connect(array $params, $username = null, $password = null, array $driverOptions = array()): Driver\Connection
    {
        return new DriverConnectionMock();
    }

    /**
     * {@inheritdoc}
     */
    public function getSchemaManager(Connection $conn, AbstractPlatform $platform)
    {
        if ($this->_schemaManagerMock === null) {
            return new SchemaManagerMock($conn);
        } else {
            return $this->_schemaManagerMock;
        }
    }

    /* MOCK API */

    /**
     * @param AbstractPlatform $platform
     *
     * @return void
     */
    public function setDatabasePlatform(AbstractPlatform $platform)
    {
        $this->_platformMock = $platform;
    }

    /**
     * @param AbstractSchemaManager $sm
     *
     * @return void
     */
    public function setSchemaManager(AbstractSchemaManager $sm)
    {
        $this->_schemaManagerMock = $sm;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'mock';
    }

    /**
     * {@inheritdoc}
     */
    public function getDatabase(Connection $conn)
    {
        return;
    }

    public function convertExceptionCode(Exception $exception): int
    {
        return 0;
    }

    /**
     * @throws Exception
     */
    public function getExceptionConverter(): ExceptionConverter
    {
        throw new NotImplemented(__METHOD__);
    }
}
