# Laravchat

Laravchat is a real-time chat package that will enable logged in users in an application to start conersations with other users and chat in real-time for Laravel 5.4+.
This package works with Laravel, Vuejs, Pusher and Laravel Echo.

## Prerequisite

You will need to have Pusher keys. Go to pusher.com and register for free, create an app and you will get your keys for the package.

## Installing

To install the package just run
```
composer require frutdev/laravchat
```

After this you'll have to have some things, follow these instructions:

First of all you will need to run
```
composer require pusher/pusher-php-server "~3.0"
npm install
npm install --save laravel-echo pusher-js
```

This package uses ```Carbon``` package so make sure to run, if you don't have it already:
```
composer require nesbot/carbon
```

## IMPORTANT

Configure your ```.env``` file with your Pusher Key ```PUSHER_APP_ID```, ```PUSHER_APP_KEY```,```PUSHER_APP_SECRET```.

Within the ```.env``` file also modify the ```BROADCAST_DRIVER``` field with ```pusher``` so it should look like this: ```BROADCAST_DRIVER=pusher```

Go to ```vendor/frutdev/laravchat/src/resources/js/bootstrap.js``` and modify ```YOUR_APP_KEY``` and ```YOUR_APP_CLUSTER``` with the corresponding pusher key and cluster of your app


In ```config/broadcasting.php``` add the following to the ```options``` in ```pusher```

```
'cluster' => 'us2',  //OR YOUR OWN CLUSTER
'encrypted' => false,
```

Run
```
php artisan make:auth
```


Run
```
php artisan vendor:publish
```

And select ```Frutdev\Laravchat\LaravchatServiceProvider```

After doing this add the following line to your the ```mix``` in ```webpack.mix.js```
```
.js('resources/assets/laravchatjs/laravchat.js', 'public/js')
```

Add on top of your ```resources/views/layouts/app.blade.php```
```
<link href="{{ asset('css/laravchat.css') }}" rel="stylesheet">
```

And on the bottom add

```
<div id="chat">
	@yield('chat')
</div>
<!-- Scripts -->
<script src="{{ asset('js/laravchat.js') }}"></script>
```
Note that this ```<div id="chat></div>```will be outside your default ```<div id=app></div>``` which surrounds all your application content.
	

ALMOST THERE!

Uncomment the following line in ```config/app.php```
```
App\Providers\BroadcastServiceProvider::class
``` 

This package assumes your User model is in ```App\User```
Add to your User model ```UserTrait``` so it should look like this:

```
use Frutdev\Laravchat\Traits\UserTrait;

class User extends Authenticatable {
	use UserTrait;
```

Run
```
npm run dev
php artisan migrate
php artisan serve
```

Go to your localhost and enter ```/chat``` and you'll be able to create chats with any user.


## Versioning

V 1.0.0

## Authors

* **Carlos Frutos** - *Developer* 


## Notes

* If you have recomendations for a better UI I'm all ears!
* First package so if there are things that can be upgraded for installation please tell me.
* Still more things to come and upgrade such as conversation within more than 2 people, add people to conversation and more.

## TODO
* Add emojis
* Conversations between more than 2 users
* Any other suggestion?