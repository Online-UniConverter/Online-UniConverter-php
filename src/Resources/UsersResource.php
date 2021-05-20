<?php

namespace MediaConvert\Resources;

use MediaConvert\Models\User;

class UsersResource extends AbstractResource
{
    /**
     * @return User
     * @throws \Http\Client\Exception
     */
    public function me(): User
    {
        $response = $this->httpTransport->get($this->httpTransport->getBaseUri() . '/me');
        return $this->hydrator->createObjectByResponse(User::class, $response);
    }
}
