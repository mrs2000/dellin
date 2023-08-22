PHP API Деловых Линий
=================

---
https://dev.dellin.ru/api/

Installation
---

The preferred way to install this extension is through 
[composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist mrssoft/dellin "*"
```

or add

```
"mrssoft/dellin": "*"
```

to the require section of your `composer.json` file.

Usage
---

```php
$bot = new \mrssoft\icqbotapi\IcqBot();
$bot->token = 'token';

$response = $bot->self();

$bot->sendText('@nick', 'Message');

$bot->sendText('@nick', 'Message', [
    [
        'text' => 'Button', 
        'callbackData' => 'my-data', 
        'style' => 'primary'
    ]
]);
```

```php
$bot = new \mrssoft\icqbotapi\IcqBot();
$bot->token = 'token';
$bot->mutex => FileMutex::class;

$events = $bot->pollEvents();

foreach ($events as $event) {
    if ($event instanceof IcqEventCallbackQuery) {
        $event->answer([
            'text' => 'callbackData: ' . $event->callbackData,
            'showAlert' => true,
            //'url' => 'https://ya.ru/',
        ]);
    }
}
```