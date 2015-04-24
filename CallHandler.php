<?php

/**
 * Class CallHandler
 */
class CallHandler
{
    protected $_password = '7539';

    private $_apiKey = API_KEY_VMESTOSMS;

    /**
     * @param $phone
     * @return bool|string
     */
    public function callWithPassword($phone)
    {
        $data = [
            "apiKey"   => $this->_apiKey,
            "phone"    => "7{$phone}",
            "password" => $this->_password
        ];
        $context = [
            'http' => [
                'method' => 'GET',
                "timeout" => 30,
            ]
        ];
        return file_get_contents(
            "https://vmestosms.ru/call.php?".http_build_query($data),
            false,
            stream_context_create($context)
        );
    }

    /**
     * @param string $password
     * @return bool
     */
    public function validatePassword($password)
    {
        return json_encode($password === $this->_password);
    }
}