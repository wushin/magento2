<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Setup\Module;

class ResourceFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ResourceFactory
     */
    private $resourceFactory;

    protected function setUp()
    {
        $serviceLocatorMock = $this->getMockForAbstractClass('Zend\ServiceManager\ServiceLocatorInterface', ['get']);
        $connectionFactory = new ConnectionFactory($serviceLocatorMock);
        $serviceLocatorMock
            ->expects($this->once())
            ->method('get')
            ->with('Magento\Setup\Module\ConnectionFactory')
            ->will($this->returnValue($connectionFactory));
        $this->resourceFactory = new ResourceFactory($serviceLocatorMock);
    }

    public function testCreate()
    {
        $resource = $this->resourceFactory->create(
            $this->getMock('Magento\Framework\App\DeploymentConfig', [], [], '', false)
        );
        $this->assertInstanceOf('Magento\Framework\App\Resource', $resource);
    }
}
