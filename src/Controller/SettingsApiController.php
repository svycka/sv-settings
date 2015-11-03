<?php

namespace Svycka\Settings\Controller;

use Svycka\Settings\Collection\CollectionsManager;
use Svycka\Settings\Exception\SettingDoesNotExistException;
use Zend\Mvc\Controller\AbstractRestfulController;
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
     * @param CollectionsManager $settingsManager
     */
    public function __construct(CollectionsManager $settingsManager)
    {
        $this->settingsManager = $settingsManager;
    }

    /**
     * Get list of settings in the given collection
     *
     * @return array|ApiProblemResponse
     */
    public function getList()
    {
        $settings = $this->getCollection();

        if (!$settings) {
            return $this->collectionNotFoundResponse();
        }

        return new JsonModel($settings->getList());
    }

    /**
     * Get one setting by name from collection
     *
     * @param mixed $name
     *
     * @return array|ApiProblemResponse
     */
    public function get($name)
    {
        $settings = $this->getCollection();

        if (!$settings) {
            return $this->collectionNotFoundResponse();
        }

        try {
            $value = $settings->getValue($name);
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
     * @return mixed|ApiProblemResponse
     */
    public function create($data)
    {
        if (!ArrayUtils::isHashTable($data)) {
            return new ApiProblemResponse(new ApiProblem(400, 'Data should be array of key => value pairs.'));
        }

        $settings = $this->getCollection();

        if (!$settings) {
            return $this->collectionNotFoundResponse();
        }

        try {
            foreach ($data as $key => $value) {
                if ($settings->isValid($key, $value)) {
                    continue;
                }

                return new ApiProblemResponse(new ApiProblem(400, 'Invalid parameters provided.'));
            }
        } catch (SettingDoesNotExistException $exception) {
            return new ApiProblemResponse(new ApiProblem(404, $exception->getMessage()));
        }

        foreach ($data as $key => $value) {
            $settings->setValue($key, $value);
        }

        return new JsonModel($data);
    }

    /**
     * Update one setting in collection by setting name
     *
     * @param string $name
     * @param mixed $data
     *
     * @return ApiProblemResponse
     */
    public function update($name, $data)
    {
        $settings = $this->getCollection();

        if (!$settings) {
            return $this->collectionNotFoundResponse();
        }

        if (!$settings->isValid($name, $data)) {
            return new ApiProblemResponse(new ApiProblem(400, 'Invalid parameters provided.'));
        }

        try {
            $settings->setValue($name, $data);
            return new JsonModel([$name => $data]);
        } catch (SettingDoesNotExistException $exception) {
            return new ApiProblemResponse(new ApiProblem(404, $exception->getMessage()));
        }
    }

    /**
     * Create or update settings in collection
     *
     * @param mixed $data
     *
     * @return mixed|ApiProblemResponse
     */
    public function replaceList($data)
    {
        return $this->create($data);
    }

    /**
     * Gets collection name from route and returns collection object
     *
     * @return null|\Svycka\Settings\Collection\CollectionInterface
     */
    private function getCollection()
    {
        $collection = $this->params()->fromRoute('collection');

        if (!$this->settingsManager->has($collection)) {
            return null;
        }

        return $this->settingsManager->get($collection);
    }

    /**
     * Create NotFound response
     *
     * @return ApiProblemResponse
     */
    private function collectionNotFoundResponse()
    {
        return new ApiProblemResponse(new ApiProblem(404, 'Settings collection not found.'));
    }

    /**
     * workaround: for https://github.com/zendframework/zend-mvc/issues/42
     * {@inheritdoc}
     */
    protected function processBodyContent($request)
    {
        $content = $request->getContent();

        // JSON content? decode and return it.
        if ($this->requestHasContentType($request, self::CONTENT_TYPE_JSON)) {
            return json_decode($content, $this->jsonDecodeType);
        }

        parse_str($content, $parsedParams);

        // If parse_str fails to decode, or we have a single element with empty value
        if (!is_array($parsedParams) || empty($parsedParams)
            || (1 == count($parsedParams) && '' === reset($parsedParams))
        ) {
            return $content;
        }

        return $parsedParams;
    }
}