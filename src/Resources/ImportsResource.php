<?php

namespace OnlineUniConverter\Resources;

use OnlineUniConverter\Models\Common;
use OnlineUniConverter\Models\Import;
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
     * @return Import
     */
    public function upload(Import $import, $file, string $fileName = ""): Import
    {
        if ($import->getOperation() !== 'import/upload') {
            throw new \BadMethodCallException('The import operation is not import/upload');
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

        $response = $this->httpTransport->upload($form->url, $file, $parameters);

        return $this->hydrator->hydrateObjectByResponse($import, $response);
    }
}
