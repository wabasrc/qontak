<?php

namespace Wabasrc\Qontak;

class Language extends Request
{
    protected $endpoint = '/api/open/v1/templates/language';

    public function get()
    {
        $this->setEndpoint('GET', $this->endpoint);

        $auth = (new Auth)->get();
        if ($auth->status) {
            $this->setApiKey($auth->data->access_token);
        } else {
            return $this;
        }

        $this->withAuth();

        $this->hit();

        if ($this->status == true) {
            $data = json_decode(json_encode($this->responseData));

            $this->data = $data->data;
        }

        return $this;
    }
}
