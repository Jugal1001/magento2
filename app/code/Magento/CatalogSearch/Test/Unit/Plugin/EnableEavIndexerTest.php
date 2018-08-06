<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\CatalogSearch\Test\Unit\Plugin;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager as ObjectManagerHelper;

class EnableEavIndexerTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Magento\CatalogSearch\Plugin\EnableEavIndexer
     */
    private $model;

    /**
     * @var \Magento\Config\Model\Config|\PHPUnit_Framework_MockObject_MockObject
     */
    private $config;

    protected function setUp()
    {
        $this->config = $this->getMockBuilder(\Magento\Config\Model\Config::class)
            ->disableOriginalConstructor()
            ->setMethods(['getData', 'setData'])
            ->getMock();

        $objectManagerHelper = new ObjectManagerHelper($this);
        $this->model = $objectManagerHelper->getObject(
            \Magento\CatalogSearch\Plugin\EnableEavIndexer::class
        );
    }

    public function testBeforeSave()
    {
        $this->config->expects($this->once())
            ->method('getData')
            ->willReturn('elasticsearch');
        $this->config->expects($this->never())
            ->method('setData')
            ->willReturnSelf();

        $this->model->beforeSave($this->config);
    }

    public function testBeforeSaveMysqlSearchEngine()
    {
        $this->config->expects($this->at(0))
            ->method('getData')
            ->willReturn('mysql');
        $this->config->expects($this->at(1))
            ->method('getData')
            ->willReturn([]);
        $this->config->expects($this->once())
            ->method('setData')
            ->willReturnSelf();

        $this->model->beforeSave($this->config);
    }
}
