# Laravchat

Laravchat is a real-time chat package that will enable logged in users in an application to start conersations with other users and chat in real-time for Laravel 5.4+

## Installing

To install the package just run
```
composer require frutdev/laravchat v1.0.0
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
Configure your ```.env``` file with your Pusher Key and go to ```vendor/frutdev/laravchat/src/resources/js/bootstrap.js``` and modify ```YOUR_APP_KEY``` and ```YOUR_APP_CLUSTER``` with the corresponding pusher key and cluster.


In ```config/broadcasting.php``` add the following to the ```options``` in ```pusher```

```
'cluster' => 'us2',  //OR YOUR OWN CLUSTER
'encrypted' => true,
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


If you are using ```Vue.js``` in your aplication this might be a little tricky but I will look into how to merge my file with ```js/app.js```

Within your ```resources/views/layouts/app.blade.php``` 

Add on top
```
<link href="{{ asset('css/laravchat.css') }}" rel="stylesheet">
```

And on the bottom remove

```
<script src="{{ asset('js/app.js') }}"></script>
```

and add

```
<script src="{{ asset('js/laravchat.js') }}"></script>
```


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

Go to your localhost and enter ```/chat``` and you'll be able to chat with any user

## Versioning

V 1.0.0

## Authors

* **Carlos Frutos** - *Developer* 


## Notes

* If you have recomendations for a better UI I'm all ears!
* First package so if there are things that can be upgraded for installation please tell me.
* Still more things to come and upgrade such as conversation within more than 2 people, add people to conversation and more.

