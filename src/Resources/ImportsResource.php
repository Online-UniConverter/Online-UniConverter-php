<?php

namespace MediaConvert\Resources;

use MediaConvert\Models\Common;
use MediaConvert\Models\Import;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class ImportsResource extends AbstractResource
{
    /**
     * @param Import $import
     *
     * @return Import
     */
    public function create(Import $import): Import
    {
        $response = $this->httpTransport->post($this->httpTransport->getBaseUri() . '/' . $import->getOperation(), $import->getPayload() ?? []);
        return $this->hydrator->hydrateObjectByResponse($import, $response);
    }

    /**
     * @param Import $import
     *
     * @return Import
     */
    public function info(Import $import): Import
    {
        $response = $this->httpTransport->get($this->httpTransport->getBaseUri() . '/tasks/' . $import->getId());

        return $this->hydrator->hydrateObjectByResponse($import, $response);
    }

    /**
     * @param Import $import
     * @param string|resource|StreamInterface $file
     * @param string|null $fileName
     *
     * @return ResponseInterface
     */
    public function upload(Import $import, $file, string $fileName = ""): ResponseInterface
    {
        if ($import->getOperation() !== 'import/upload') {
            throw new \BadMethodCallException('The import operation is not import/upload');
        }
        if ($import->getStatus() !== Common::STATUS_WAITING
            || !$import->getResult()
            || !isset($import->getResult()->form)) {
            throw new \BadMethodCallException('The import is not ready for uploading');
        }
        if ($fileName == "") {
            throw new \BadMethodCallException('The file name is not be null');
        }
        $form = $import->getResult()->form;
        $parameters = (array)$form->parameters ?? [];

        // rename
        $parameters['name'] = $fileName;

        // unset
        unset($parameters['expire']);

        return $this->httpTransport->upload($form->url, $file, $parameters);
    }
}
