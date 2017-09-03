<p align="center">
  <img src="https://github.com/codestudiohq/laravel-totem/blob/master/resources/assets/img/totem.png?raw=true" alt="Laravel Totem"/>
</p>
<p align="center">
<a href="https://travis-ci.org/codestudiohq/laravel-totem"><img src="https://travis-ci.org/codestudiohq/laravel-totem.svg" alt="Build Status"></a>
<a href="https://styleci.io/repos/99050894"><img src="https://styleci.io/repos/99050894/shield?branch=master" alt="StyleCI"></a>
<a href="https://packagist.org/packages/studio/laravel-totem"><img src="https://poser.pugx.org/studio/laravel-totem/license.svg" alt="License"></a>
</p>

# Introduction

> `Laravel Totem` is in its `Alpha` state. Its still a work in progress. Please proceed with caution and on your own risk.

Manage your `Laravel Schedule` from a pretty dashboard. Schedule your `Laravel Console Commands` to your liking. Enable/Disable scheduled tasks on the fly without going back to your code again.

## Documentation

#### Compatiblity Matrix

|<p align="left">Laravel</p> |    Totem  | 
|:-------|----------:|
|master  |     master|
|5.5     |     2.0   |
|5.4     |     1.0   |

#### Installing

`Totem` requires Laravel v5.4 and above. Use composer to install totem to your Laravel project

```
composer require studio/laravel-totem
```

> Laravel Totem supports auto package discovery for Laravel v5.5, therefore service provider registration is not required in Laravel v5.5

Add `TotemServiceProvider` to the `providers` array of your Laravel v5.4 application's config/app.php

```php
Studio\Totem\Providers\TotemServiceProvider::class,
```

Once `Laravel Totem` is installed & registered, 

- Run the migration

```
php artisan migrate
```

- Publish `Totem` assets to your public folder using the following command

```    
php artisan totem:assets
```

#### Updating

Please republish totem assets after updating totem to a new version

```    
php artisan totem:assets
```

#### Configuration

##### Cron Job

This package assumes that you have a good understanding of [Laravel's Task Scheduling](https://laravel.com/docs/5.4/scheduling) and [Laravel Console Commands](https://laravel.com/docs/5.4/artisan#writing-commands). Before any of this works please make sure you have a cron running as follows:

```
* * * * * php /path-to-your-project/artisan schedule:run >> /dev/null 2>&1
```

##### Web Dashboard 

`Laravel Totem`'s  dashboard is inspired by `Laravel Horizon`. Just like Horizon you can configure authentication to `Totem`'s dashboard. Add the following to the boot method of your AppServiceProvider or wherever you might seem fit.   

```php
use Studio\Totem\Totem;

Totem::auth(function($request) {
    // return true / false . For e.g.
    return Auth::check();
});
```

By default Totem's dashboard only works in local environment. To view the dashboard point your browser to /totem of your app. For e.g. laravel.dev/totem.

#### Making Commands available in `Laravel Totem`

All artisan commands can be scheduled. If you want to hide a command from Totem make sure you have the `hidden` attribute set to true in your command. For e.g.

```php
protected $hidden = true;
```

From L5.5 onwards all commands are auto registered, so this wouldn't be a problem.

#### Command Parameters

If your command requires arguments or options please use the optional command parameters field. You can provide parameters to your command as a string in the following manner

```text
name=john.doe --greetings='Welcome to the new world'
```
In the example above, name is an argument while greetings is an option

#### Console Command

In addition to the dashboard, Totem provides an artisan command to view a list of scheduled task.

```    
php artisan schedule:list
```

### Screenshots

##### Task List
<img src="https://github.com/codestudiohq/laravel-totem/blob/master/public/img/screenshots/tasks.png?raw=true" alt="Task List"/>

##### Task Details
<img src="https://github.com/codestudiohq/laravel-totem/blob/master/public/img/screenshots/task-details.png?raw=true" alt="Task List"/>

##### Edit Task
<img src="https://github.com/codestudiohq/laravel-totem/blob/master/public/img/screenshots/edit-task.png?raw=true" alt="Task List"/>

##### Artisan Command to view scheduled tasks
<img src="https://github.com/codestudiohq/laravel-totem/blob/master/public/img/screenshots/artisan.png?raw=true" alt="Task List"/>
 
## Changelog

Important versions listed below. Refer to the [Changelog](CHANGELOG.md) for a full history of the project.

- [1.0](CHANGELOG.md) - TBD

## Credits

- [Roshan Gautam](https://twitter.com/@roshangautam)

Bug reports, feature requests, and pull requests can be submitted by following our [Contribution Guide](CONTRIBUTING.md).

## Contributing & Protocols

- [Versioning](CONTRIBUTING.md#versioning)
- [Coding Standards](CONTRIBUTING.md#coding-standards)
- [Pull Requests](CONTRIBUTING.md#pull-requests)

## License

This software is released under the [MIT](LICENSE) License.

 © 2017 Roshan Gautam, All rights reserved.
