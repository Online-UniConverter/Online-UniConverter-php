<?php

namespace OnlineUniConverter\Resources;

use OnlineUniConverter\Models\Export;

class ExportsResource extends AbstractResource
{
    /**
     * @param Export $export
     *
     * @return Export
     */
    public function create(Export $export): Export
    {
        $response = $this->httpTransport->post($this->httpTransport->getBaseUri() . '/' . $export->getOperation(), $export->getPayload() ?? []);
        return $this->hydrator->hydrateObjectByResponse($export, $response);
    }

    /**
     * @param Export $export
     *
     * @return Export
     */
    public function info(Export $export): Export
    {
        $response = $this->httpTransport->get($this->httpTransport->getBaseUri() . '/tasks/' . $export->getId());
        return $this->hydrator->hydrateObjectByResponse($export, $response);
    }
}
