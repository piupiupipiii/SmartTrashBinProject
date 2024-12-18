<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpMqtt\Client\Facades\MQTT;

class SubscribeMqtt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:subscribe-mqtt';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        /** @var \PhpMqtt\Client\Contracts\MqttClient $mqtt */
        $mqtt = MQTT::connection();
        $mqtt->subscribe('trashbin/pintu', function (string $topic, string $message) {
            echo sprintf('Received QoS level 1 message on topic [%s]: %s', $topic, $message);
        }, 1);
        $mqtt->subscribe('trashbin/data', function (string $topic, string $message) {
            echo sprintf('Received QoS level 1 message on topic [%s]: %s', $topic, $message);
        }, 1);
        $mqtt->loop(true);

        /** @var \PhpMqtt\Client\Contracts\MqttClient $mqtt */
        pcntl_signal(SIGINT, function () use ($mqtt) {
            $mqtt->interrupt();
        });
    }
}
