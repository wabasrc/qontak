<?php

namespace Wabasrc\Qontak;

class Broadcast extends Request
{
    protected function formatAttr($value)
    {

        $data = [
            'name' => '',
            'message_template_id' => '',
            'contact_list_id' => '',
            'channel_integration_id' => $this->channelId,
            'execute_type' => '',
            'send_at' => '',
            'parameters' => []
        ];

        foreach ($data as $k => $v) {
            if (array_key_exists($k, $value)) {
                $data[$k] = $value[$k];
            }
        }

        return $data;
    }

    public function send($name, $templateId, $listId, $executeType, $sendAt, $body = [])
    {
        $endpoint = '/api/open/v1/broadcasts/whatsapp';

        $this->setEndpoint('POST', $endpoint);
        $this->setBody($this->formatAttrIndirect([
            'name' => $name,
            'message_template_id' => $templateId,
            'contact_list_id' => $listId,
            'execute_type' => $executeType,
            'send_at' => $sendAt,
            'parameters' => [
                'body' => $body
            ]
        ]));

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
