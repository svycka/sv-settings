<?php

namespace Svycka\Settings\Controller;

use Svycka\Settings\Collection\CollectionInterface;
use Svycka\Settings\Collection\CollectionsManager;
use Svycka\Settings\Exception\SettingDoesNotExistException;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\Mvc\MvcEvent;
use Zend\Stdlib\ArrayUtils;
use Zend\View\Model\JsonModel;
use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
final class SettingsApiController extends AbstractRestfulController
{
    /**
     * Name of request or query parameter containing identifier
     *
     * @var string
     */
    protected $identifierName = 'name';

    /**
     * @var CollectionsManager
     */
    protected $settingsManager;

    /**
     * @var CollectionInterface
     */
    protected $settings;

    /**
     * @param CollectionsManager $settingsManager
     */
    public function __construct(CollectionsManager $settingsManager)
    {
        $this->settingsManager = $settingsManager;
    }

    /**
     * Get list of settings in the given collection
     *
     * @return JsonModel
     */
    public function getList()
    {
        return new JsonModel($this->settings->getList());
    }

    /**
     * Get one setting by name from collection
     *
     * @param mixed $name
     *
     * @return JsonModel|ApiProblemResponse
     */
    public function get($name)
    {
        try {
            $value = $this->settings->getValue($name);
            return new JsonModel([$name => $value]);
        } catch (SettingDoesNotExistException $exception) {
            return new ApiProblemResponse(new ApiProblem(404, $exception->getMessage()));
        }
    }

    /**
     * Create or update settings in collection
     *
     * @param array $data
     *
     * @return JsonModel|ApiProblemResponse
     */
    public function create($data)
    {
        if (!ArrayUtils::isHashTable($data)) {
            return new ApiProblemResponse(new ApiProblem(400, 'Data should be array of key => value pairs.'));
        }

        try {
            foreach ($data as $key => $value) {
                if ($this->settings->isValid($key, $value)) {
                    continue;
                }

                return new ApiProblemResponse(new ApiProblem(400, 'Invalid parameters provided.'));
            }
        } catch (SettingDoesNotExistException $exception) {
            return new ApiProblemResponse(new ApiProblem(404, $exception->getMessage()));
        }

        foreach ($data as $key => $value) {
            $this->settings->setValue($key, $value);
        }

        return new JsonModel($data);
    }

    /**
     * Update one setting in collection by setting name
     *
     * @param string $name
     * @param mixed $data
     *
     * @return JsonModel|ApiProblemResponse
     */
    public function update($name, $data)
    {
        try {
            if (!$this->settings->isValid($name, $data)) {
                return new ApiProblemResponse(new ApiProblem(400, 'Invalid parameters provided.'));
            }
            $this->settings->setValue($name, $data);
            return new JsonModel([$name => $data]);
        } catch (SettingDoesNotExistException $exception) {
            return new ApiProblemResponse(new ApiProblem(404, $exception->getMessage()));
        }
    }

    /**
     * Create or update settings in collection
     *
     * @param array $data
     *
     * @return JsonModel|ApiProblemResponse
     */
    public function replaceList($data)
    {
        return $this->create($data);
    }

    public function onDispatch(MvcEvent $event)
    {
        $collection = $this->params()->fromRoute('collection');

        if (!$this->settingsManager->has($collection)) {
            return new ApiProblemResponse(new ApiProblem(404, 'Settings collection not found.'));
        }

        $this->settings = $this->settingsManager->get($collection);

        return parent::onDispatch($event);
    }
}
