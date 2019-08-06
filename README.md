# This package has been abandoned and is no longer maintained.

Caffeinated Path
================
[![Laravel 5.2](https://img.shields.io/badge/Laravel-5.2-orange.svg?style=flat-square)](http://laravel.com)
[![Source](http://img.shields.io/badge/source-caffeinated/path-blue.svg?style=flat-square)](https://github.com/caffeinated/path)
[![License](http://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://tldrlegal.com/license/mit-license)

**Note:** This was originally part of the Caffeinated/Path package. I've extracted it out into it's own package.

Caffeinated Path allows the means to easily customize the default structure of your Laravel 5 application. This means you can take the default Laravel framework structure:

```
laravel5/
|-- app/
|-- bootstrap/
|-- config/
|-- database/
|-- public/
|-- resources/
|-- storage/
|-- tests/
```

And configure it into something like:

```
laravel5/
|-- app/
|-- bootstrap/
|-- system/
	|-- config/
	|-- database/
	|-- resources/
	|-- storage/
	|-- tests/
```

The package follows the FIG standards PSR-1, PSR-2, and PSR-4 to ensure a high level of interoperability between shared PHP code.

Quick Installation
------------------
Begin by installing the package through Composer.

```
composer require caffeinated/path=~1.0
```

Once this operation is complete, simply add the service provider class to your project's `config/app.php` file:

#### Service Provider
```php
Caffeinated\Path\PathServiceProvider::class,
```

---

Instantiate Caffeinated Path Application
----------------------------------------
First off, you'll need to use the Caffeinated Path Application instance in place of Laravel's Illuminate Foundation Application. Simply replace it within the `bootstrap/app.php` file like so:

```php
$app = new Caffeinated\Path\Application(
	realpath(__DIR__.'/../')
);
```

The Caffeinated Path Application extends the Illuminate Foundation Application and adds the ability to customize the directories via the provided `path` config file.

Now you may configure any of the base paths as you like! Though do note, that some paths require a little more setup than others:

- [Setting a Custom Config Path](#setting-a-custom-config-path)
- [Changing The Bootstrap Path](#changing-the-bootstrap-path)

Read on to find out how to configure these paths, or use the above links to jump directly to any section.

---

Setting a Custom Config Path
----------------------------
If you'd like to move your `config` directory, provide the path as the second parameter when creating a new instance of the Caffeinated Path Application:

```php
$app = new Caffeinated\Path\Application(
	realpath(__DIR__.'/../'),
	realpath(__DIR__.'/../system/config/')   // Your custom config path
);
```

Changing The Bootstrap Path
---------------------------
Caffeinated Path does not provide the means to change your `bootstrap` directory path, *because* it's a simply edit you need to make within the three following files (don't worry, it's nothing complicated):

- `public/index.php`
- `bootstrap/app.php`
- `bootstrap/autoload.php`

### Step 1: Updating `public/index.php`
First off, you'll be wanting to change the following two `require` paths within your `public/index.php` file:

```php
/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| our application. We just need to utilize it! We'll simply require it
| into the script here so that we don't have to worry about manual
| loading any of our classes later on. It feels nice to relax.
|
*/

require __DIR__.'/../bootstrap/autoload.php';

/*
|--------------------------------------------------------------------------
| Turn On The Lights
|--------------------------------------------------------------------------
|
| We need to illuminate PHP development, so let us turn on the lights.
| This bootstraps the framework and gets it ready for use, then it
| will load up this application so that we can run it and send
| the responses back to the browser and delight our users.
|
*/

$app = require_once __DIR__.'/../bootstrap/app.php';
```

### Step 2: Updating `bootstrap/app.php`
Secondly, open your `bootstrap/app.php` file and update the relevant path to your application base:

```php
$app = new Caffeinated\Path\Application(
	realpath(__DIR__.'/../')                   // Update this path
);
```

### Step 3: Updating `bootstrap/autoload.php`
Lastly, open your `bootstrap/autoload.php` file and update both the *Composer autoload* and *compiled class* paths:

```php
/*
|--------------------------------------------------------------------------
| Register The Composer Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader
| for our application. We just need to utilize it! We'll require it
| into the script here so that we do not have to worry about the
| loading of any our classes "manually". Feels great to relax.
|
*/

require __DIR__.'/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Include The Compiled Class File
|--------------------------------------------------------------------------
|
| To dramatically increase your application's performance, you may use a
| compiled class file which contains all of the classes commonly used
| by a request. The Artisan "optimize" is used to create this file.
|
*/

$compiledPath = __DIR__.'/../storage/framework/compiled.php';
```

That should be it! Simply fire up your app to verify.
