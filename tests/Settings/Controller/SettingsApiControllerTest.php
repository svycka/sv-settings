<?php

namespace Svycka\SettingsTest\Controller;

use Svycka\Settings\Collection\CollectionInterface;
use Svycka\Settings\Collection\CollectionsManager;
use Svycka\Settings\Controller\SettingsApiController;
use Svycka\Settings\Exception\SettingDoesNotExistException;
use TestAssets\CustomCollection;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use Zend\ServiceManager\Config;
use Zend\Stdlib\Parameters;
use Zend\View\Model\JsonModel;
use ZF\ApiProblem\ApiProblemResponse;

/**
 * @author  Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
class SettingsApiControllerFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var SettingsApiController */
    private $controller;
    /** @var CollectionsManager */
    private $manager;
    /** @var Request */
    private $request;
    /** @var Response */
    private $response;
    /** @var RouteMatch */
    private $routeMatch;
    /** @var MvcEvent */
    private $event;

    public function setUp()
    {
        $config = new Config(['invokables' => [
            'my-collection' => CustomCollection::class,
        ]]);
        $this->manager = new CollectionsManager($config);
        $this->controller = new SettingsApiController($this->manager);
        $this->request = new Request();
        $this->response = new Response();
        $this->event = new MvcEvent();
        $this->routeMatch = new RouteMatch([
            'collection' => 'my-collection'
        ]);
        $this->event->setRouteMatch($this->routeMatch);
        $this->controller->setEvent($this->event);
    }

    public function testCanGetList()
    {
        /** @var JsonModel $result */
        $result = $this->controller->dispatch($this->request, $this->response);

        $this->assertInstanceOf(JsonModel::class, $result);
        $this->assertCount(3, $result->getVariables());
    }

    public function testCanReturnNotFoundCollection()
    {
        $manager = $this->prophesize(CollectionsManager::class);
        $manager->has('not-exist')->willReturn(false);
        $controller = new SettingsApiController($manager->reveal());
        $controller->setEvent($this->event);
        $this->routeMatch->setParam('collection', 'not-exist');

        /** @var ApiProblemResponse $result */
        $result = $controller->dispatch($this->request, $this->response);

        $this->assertInstanceOf(ApiProblemResponse::class, $result);
        $this->assertEquals(404, $result->getStatusCode());
        $this->assertEquals('Settings collection not found.', $result->getApiProblem()->detail);
    }

    public function testCanGetSetting()
    {
        $this->routeMatch->setParam($this->controller->getIdentifierName(), 'temperature_unit');
        /** @var JsonModel $result */
        $result = $this->controller->dispatch($this->request, $this->response);

        $this->assertInstanceOf(JsonModel::class, $result);
        $this->assertEquals('C', $result->getVariable('temperature_unit'));
    }

    public function testCanReturnNotFoundSetting()
    {
        $collection = $this->prophesize(CollectionInterface::class);
        $collection->getValue($settingName = 'undefined-setting')
            ->willThrow(new SettingDoesNotExistException($exceptionMessage = 'setting not found'));
        $this->manager->setService('collection_name', $collection->reveal());
        $this->routeMatch->setParam($this->controller->getIdentifierName(), $settingName);
        $this->routeMatch->setParam('collection', 'collection_name');
        /** @var JsonModel $result */
        $result = $this->controller->dispatch($this->request, $this->response);

        $this->assertInstanceOf(ApiProblemResponse::class, $result);
        $this->assertEquals(404, $result->getStatusCode());
        $this->assertEquals($exceptionMessage, $result->getApiProblem()->detail);
    }

    public function testCanSetOneSetting()
    {
        $this->routeMatch->setParam($this->controller->getIdentifierName(), 'temperature_unit');
        $this->request->setContent('F');
        $this->request->setMethod(Request::METHOD_PUT);
        /** @var JsonModel $result */
        $result = $this->controller->dispatch($this->request, $this->response);

        $this->assertInstanceOf(JsonModel::class, $result);
        $this->assertEquals('F', $result->getVariable('temperature_unit'));
        $this->assertEquals('F', $this->manager->get('my-collection')->getValue('temperature_unit'));
    }

    public function testCanDetectInvalidData()
    {
        $this->routeMatch->setParam($this->controller->getIdentifierName(), 'temperature_unit');
        $this->request->setContent('invalid');
        $this->request->setMethod(Request::METHOD_PUT);
        /** @var JsonModel $result */
        $result = $this->controller->dispatch($this->request, $this->response);

        $this->assertInstanceOf(ApiProblemResponse::class, $result);
        $this->assertEquals(400, $result->getStatusCode());
        $this->assertEquals('Invalid parameters provided.', $result->getApiProblem()->detail);
    }

    public function testCanReturnNotFoundSettingWhenSettingOneSetting()
    {
        $collection = $this->prophesize(CollectionInterface::class);
        $collection->isValid($settingName = 'undefined-setting', $value = 'F')
            ->willThrow(new SettingDoesNotExistException($exceptionMessage = 'setting not found'));
        $this->manager->setService('collection_name', $collection->reveal());
        $this->routeMatch->setParam($this->controller->getIdentifierName(), $settingName);
        $this->request->setContent($value);
        $this->request->setMethod(Request::METHOD_PUT);
        $this->routeMatch->setParam('collection', 'collection_name');
        /** @var JsonModel $result */
        $result = $this->controller->dispatch($this->request, $this->response);

        $this->assertInstanceOf(ApiProblemResponse::class, $result);
        $this->assertEquals(404, $result->getStatusCode());
        $this->assertEquals($exceptionMessage, $result->getApiProblem()->detail);
    }

    public function testCanSetSettings()
    {
        $this->routeMatch->setParam($this->controller->getIdentifierName(), 'temperature_unit');
        $post = new Parameters([
            'temperature_unit' => 'F',
            'distance_unit' => 'km'
        ]);
        $this->request->setPost($post);
        $this->request->setMethod(Request::METHOD_POST);
        /** @var JsonModel $result */
        $result = $this->controller->dispatch($this->request, $this->response);

        $this->assertInstanceOf(JsonModel::class, $result);
        $this->assertEquals('F', $result->getVariable('temperature_unit'));
        $this->assertEquals('km', $result->getVariable('distance_unit'));
        $this->assertEquals('F', $this->manager->get('my-collection')->getValue('temperature_unit'));
        $this->assertEquals('km', $this->manager->get('my-collection')->getValue('distance_unit'));
    }
}
