<?php

namespace App\Kernal\Traits;

use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\JsonApiSerializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Exception\ValidatorException;

trait JsonApi
{

    /**
     * @param array|object $data
     * @param object $transformer
     * @param string $resourceKey
     * @param bool $isCollection
     * @return array|null
     * transform object or array of objects to json api format
     */
    public function srializeToJsonApi(array|object $data, object $transformer, string $resourceKey, bool $isCollection = false): array
    {

        $this->jsonApiManger = new Manager();
        $this->jsonApiManger->setSerializer(new JsonApiSerializer());


        $resource = $isCollection ? new Collection($data, $transformer, $resourceKey) : new Item($data, $transformer, $resourceKey);


        // Pass this array (collection) into a resource, which will also have a "Transformer"
        return $this->jsonApiManger->createData($resource)->toArray();
    }

    /**
     * extract json from request and deserialize json api to array
     * @param Request $request
     * @return mixed
     */
    public function getAttributesData(Request $request): array
    {
        $body = $request->getContent();
        $data = json_decode($body, true);
        if (isset($data['data'])) {
            if (isset($data['data']['attributes'])) {
                return $data['data']['attributes'];
            }
            throw new ValidatorException("attributes not found");
        }
        throw new ValidatorException("data not found");

    }
}

