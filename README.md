# Telstra Developer SMS Services wrapper
This is a simple PHP wrapper for [Telstra Developer SMS Services](https://dev.telstra.com/sms-quick-start) version 1.

## Basic Usage
```php
$client = new TelstraClient(new TelstraConfig($apiKey, $apiSecret));

// Sending an SMS message
$send = new TelstraSmsSend($client);
$messageId = $send->message("This is a test of the computer's navigational systems")->to('04xxxxxxxx')->send();
print 'Sent message and got messageId ' . $messageId . PHP_EOL;
print str_repeat('-', 40) . PHP_EOL;

// Checking the status of a sent message
$status = new TelstraSmsStatus($client);
$status->fetch($messageId);

print 'Description: ' . $status->getDescription() . PHP_EOL;
print 'Recipient: ' . $status->recipient . PHP_EOL;
print 'Sent: ' . $status->sent->format('Y-m-d H:i:s e') . PHP_EOL;
print 'Received: ' . $status->received->format('Y-m-d H:i:s e') . PHP_EOL;

print str_repeat('-', 40) . PHP_EOL;

// Getting message responses
$responses = new TelstraSmsResponses($client);
$responses->fetch($messageId);

$i = 1;

array_map(function ($response) use (&$i, $responses) {
    printf('%d of %d...%s', $i, count($responses), PHP_EOL);
    print 'Sender: ' . $response->from . PHP_EOL;
    print 'Acknowledged: ' . $response->acknowledgedTimestamp->format('Y-m-d H:i:s e') . PHP_EOL;
    print 'Message: ' . $response->content . PHP_EOL;
    print str_repeat('-', 40) . PHP_EOL;
    $i++;
}, $responses->getAll());
```
