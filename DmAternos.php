<?php

class AternosStatusAnalyzer
{

    private string $serverAddress;

    private array $expectedResponses = [
        'online',
        'offline'
    ];

    private CurlHandle $curl;

    private string $response;

    public function __construct(string $serverAddress)
    {
        $this->serverAddress = "https://$serverAddress.aternos.me";
        return $this->verify();
    }

    public function __destruct()
    {
        curl_close($this->curl);
    }

    public function verify(): ?string
    {
        $this->setResponse()->getResponse();

        return in_array($this->response, $this->expectedResponses) ? $this->response : $this->debug(
            "$this->serverAddress returned an undefined status"
        );
    }

    public function getResponse(): void
    {
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        $this->response = strtolower(curl_exec($this->curl));
        curl_close($this->curl);
    }

    public function setResponse(): self
    {
        $this->curl = curl_init($this->serverAddress);
        return $this;
    }

    public function debug(string $message): void
    {
        echo PHP_EOL . '<br><pre>' . htmlspecialchars($message) . '</pre>';
    }
}
