# Utalk

## WebHook IPs
* 40.88.132.66
* 52.188.209.245

### Route WebHook
```php
// Route: routes/web.php
    Route::any('/utalk', function () {
        event(new UtalkWebhookEvent(request()->all()));
        return response()->noContent();
    })->name('utalk');
```
### Send Message
```php
// Send Message
    $utalk = new UtalkService();
    $utalk->message()->set(
        fromPhone: '+55***********',
        toPhone: '+55***********',
        organizationId: '********',
        message: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.'
    );
```


