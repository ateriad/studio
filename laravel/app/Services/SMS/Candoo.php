<?php

namespace App\Services\SMS;

use App\Models\SmsLog;
use App\Services\SMS\Exceptions\SmsException;
use Exception;
use \SoapClient;

class Candoo implements SMS
{
    /**
     * @var SoapClient
     */
    private $client;

    public function __construct()
    {
        $context = stream_context_create(['http' => ['user_agent' => 'PHPSoapClient']]);

        $soapClientOptions = array(
            'stream_context' => $context,
            'cache_wsdl' => WSDL_CACHE_NONE
        );

        $this->client = new SoapClient(config('sms.drivers.candoo.wdsl'), $soapClientOptions);
    }

    /**
     * @inheritDoc
     * @throws SmsException
     * @throws Exception
     */
    public function send(string $phone, string $body)
    {
        if (app()->environment('local')) {
            throw new Exception('you can not send sms in local environment');
        }

        $desNos = [$this->formatPhone($phone)];

        $params = [
            'username' => config('sms.drivers.candoo.username'),
            'password' => config('sms.drivers.candoo.password'),
            'srcNumber' => config('sms.drivers.candoo.source'),
            'body' => $body,
            'destNo' => $desNos,
            'flash' => config('sms.drivers.candoo.flash')
        ];

        $result = $this->client->__call("Send", $params);

        $sms_log = new SMSLog();
        $sms_log->number = $phone;
        $sms_log->body = $body;
        $sms_log->sms_id = $result[0]->ID;
        $sms_log->save();

        if (substr($result[0]->ID, 0, 1) === "E") {
            throw new SmsException($result[0]->ID);
        }
    }

    public function receivedSMS(): array
    {
        $params = [
            'username' => config('sms.drivers.candoo.username'),
            'password' => config('sms.drivers.candoo.password'),
            'number' => config('sms.drivers.candoo.source'),
            'id' => null
        ];

        return $this->client->__soapCall('ViewReceive', $params);
    }

    public function balance(): int
    {
        $params = [
            'username' => config('sms.drivers.candoo.username'),
            'password' => config('sms.drivers.candoo.password'),
        ];

        return $this->client->__soapCall('Balance', $params);
    }

    private function formatPhone($phone)
    {
        return "98" . substr($phone, 1);
    }
}
