<?php

class IvrHandler
{
    private $_apiKey = API_KEY_WOWCALL;
    private $_host;

    public function __construct()
    {
        $this->_host = isset($_SERVER["DEFAULT_VERSION_HOSTNAME"]) ? $_SERVER["DEFAULT_VERSION_HOSTNAME"] : $_SERVER["HTTP_HOST"];
    }

    public function IvrDemo($callPhone, $callbackPhone)
    {
        $data = [
            "apiKey"   => $this->_apiKey,
            "phone"    => "7{$callPhone}",
            "xmlUrl"   => "https://{$this->_host}/front.php?callback={$callbackPhone}"
        ];
        $context = [
            'http' => [
                'method' => 'GET',
                "timeout" => 30,
            ]
        ];

        return file_get_contents(
            "https://api.wowcall.ru/call_xml.php?".http_build_query($data),
            false,
            stream_context_create($context)
        );
    }

    public function getXml($phone)
    {
        $xmlWriter = new XMLWriter();
        $xmlWriter->openMemory();

        $xmlWriter->writeRaw("<text>Нажмите 1 для переадресации на колл-центр</text>");
        $xmlWriter->writeRaw("<silence>0.5</silence>");
        $xmlWriter->writeRaw("<text>нажмите 2 для получения информации о скидках</text>");
        $xmlWriter->writeRaw("<silence>0.5</silence>");
        $xmlWriter->writeRaw("<text>нажмите 3 чтобы оставить сообщение</text>");

        $xmlWriter->startElement("dtmf");
        $xmlWriter->writeAttribute("wait", "10");

        $xmlWriter->writeRaw("<key value=\"1\"><redirect>+7{$phone}</redirect></key>");
        $xmlWriter->writeRaw('<key value="2"><audio>https://upload.wikimedia.org/wikipedia/commons/0/03/Linus-linux.ogg</audio></key>');
        $xmlWriter->writeRaw('<key value="3"><record length="10" name="record1" submit="http://www.yoursite.ru/record_submit.php"></record></key>');

        $xmlWriter->endElement();

        return $xmlWriter->outputMemory();
    }

}