# PHRONT Documentation

## Requirements

* PHP >= 8.1
* MariaDB or Mysql
* Apache2
* NodeJS >= 20.*.*
* SQLITE >= 3

## Installation

The installation process is really simple

* First clone repository
```bash
git clone https://github.com/betozar/phront.git my-project
cd my-project
```

* Then reset git and start a new repository
```bash
rm -rf .git
git init
git add . && git commit -m "first commit"
```

* Now copy `src/config.example.php` to `src/config.php`
```bash
cp src/config.example.php src/config.php
```

* Create new file for sqlite database
```bash
touch storage/database/phront.sqlite
```

* Apply SQL schema to database
```bash
sqlite3 storage/database/phront.sqlite < src/schemas/0001_users_table.sql
sqlite3 storage/database/phront.sqlite < src/schemas/0002_user_preferences_table.sql
```

## Why PHRONT

PHRONT is meant to be used in small projects, also with the minimum amount of external libraries.

In a classic PHP Application you maybe have something like this

```php
<?php

/*
	URL: /register.php
	File: public/register.php
*/

define('SOME_CONSTANT', 'value');
// ... other constant definitions

function db_connect(): PDO
{
	// ... trying to connect to database server
}

function validate_data(array $data): bool
{
	// ... validate user input data
}

function save_user(array $data): bool
{
	// ... store user data in database
}


if( $_SERVER['REQUEST_METHOD'] === 'POST' )
{
	$db = db_connect();
	// ... extract user data
	validate_data($data);
	// ... if data is correct the store it
	save_user($data);
	// ... if no errors redirect to the self page or render errors
	// ...
}

$errors =  isset($_SESSION['errors'])? $_SESSION['errors'] : [];

?>

<form method="POST" action="<?=$_SERVER['PHP_SELF']?>">
	<label for"email">Email Address</label>
	// ...
	<?php if( count($errors) > 0 ): ?>
		<?php foreach($errors as $err_field => $err_msg): ?>
			// ... render errors
		<?php endforeach; ?>
	// ... the rest of the template for the view
```

This kind of structure provides a lower level of abstraction without design patterns or a complicated architecture, inclusively without some kind of 3rd-party library dependance, our code is executed like a "cascade".

The problem here is as much as logic gets more complicated the code gets worst, because all this code mixes the view template, data processing and database management, 3rd-party services communication in a single file.

PHRONT is taking leverage of this "cascade" execution flow, but spliting related functions and settings in separate files, the same register feature looks like this with phront:


* This file has the responsibility of displaying the interface properly.

```php
/**
 * URL: /auth/register
 * File: /src/pages/auth/register.view.php
 */
<?php layout('public.header'); ?>

<h1><?=__('Register')?></h1>

<form action="/api/auth/register" method="POST">
  <label for="name"><?=__('Name')?></label>
  <input type="text" name="name" id="name" value="<?=$name?>">
  // ... rest of the form
</form>

<?php layout('public.footer'); ?>
```

* This file has the responsibility of storing the user

```php
/**
 * URL: /api/auth/register
 * File: /src/pages/api/auth/register.view.php
 */
<?php

http_only_post();
http_only_guest();

$db = db_sqlite_connect();

if( is_null($db) )
{
  flash_set('errors', [
    'email' => __('Service is unavailable')
  ]);

  http_redirect('auth/register');
}


// ... extracting and validating data

if(
  !is_null($name_failed)
  || !is_null($email_failed)
  || !is_null($password_failed)
) {
  flash_set('name', $name);
  flash_set('email', $email);
  flash_set('password', $password);
  flash_set('password_confirm', $password_confirm);

  flash_set('errors', [
    'name' => $name_failed,
    'email' => $email_failed,
    'password' => $password_failed
  ]);

  http_redirect('auth/register');
}

$stored = users_store($db, [ // this functions hashes password
  'name' => $name,
  'email' => $email,
  'password' => $password,
]);

// ... do other user related stuffs

flash_set('alert', [
  'type' => 'info',
  'message' => __('New account was created')
]);

http_redirect('auth/register');
```

We get the same result, but our code structure is much cleaner and structured, because an specific route handles the user interface and other handles the logic of registration, both with the help of global helpers.

## Lifecycle

In a classic PHP application every file can be opened by the user through the URL in the browser, something like this "/posts/editor.php" and the execution flows lives in that file, with PHRONT every route is mapped to *public/index.php* with the help of *.htaccess*, inside *public/index.php* the only instruction defined there is the requiring of *src/ini.php* which contains all the necessary settings for the entire application, also requires the proper view file at *src/pages* to display user interface or handle incoming requests.

*src/ini.php* handles the entire lifecycle for any request from the beginning until the end of the execution flow, *src/ini.php* is responsible to require settings, helpers, defines proper error handling, initialize things before view file is required and after the file is required it is responsible to clean or destruct things.

## Routing

Defining routes in PHRONT is really easy, just create a new file at *src/pages* with the extension *.view.php* then the name of the file will be matched with incoming requests.

| FILE at src/pages | URL |
|----------|----------|
| index.view.php | / |
| auth/login.view.php | /auth/login |
| api/auth/login.view.php | /api/auth/login |
| dashboard/index.view.php | /dashboard |
| dashboard/logs.view.php | /dashboard/logs |
| posts/_default.view.php | /posts/any-other-path |

* *index.view.php* is used at the top level of every folder to specify that the name of the folder is also a route, if this file not exists a "Not Found" error will be thrown, if inside that folder exists other files *.view.php* the path or the URL must be the name of that folder with the name of that file like *dashboard/logs*.

* *_default.view.php* is meant to be used when you want to catch any URL path, if you define a file like *posts/editor.view.php* the URL *posts/editor* will works but *posts/what-is-chatgpt* will be mapped to *_default.view.php*.
  * The rest of the URL path will be splitted into an array at `$_SERVER`, the access to this params is defined at `http_request_params`.
  ```
  URL: /posts/algorithms/bubble-sort
  Params: ['algorithms', 'bubble-sort']
  ```

* If the router not founds a proper *.view.php* file to handle the incoming request, a "Not Found" page will be displayed, this page is defined at *src/errors/404.view.php*.

Every *.view.php* will be required by *src/ini.php* this means everything that is required globally also will be available at every *.view.php* like settings, helpers and other stuffs defined at *src/ini.php*. 

## Settings

All the settings are defined at *src/config.php* and as a mirror for public sharing, all the settings also must be defined at *src/config.example.php*.

Example:
```php
<?php

define('MY_SERVICE_KEY', 'key');
define('MY_SERVICE_TOKEN', 'token');
```

then every constant defined at *src/config.php* will be available at any part of the application.

## Helpers

All global helper functions will be defined at *src/helpers.php*, also it is used to require files from *src/functions* to give a cleaner definition of functions, files inside it must ends with *.func.php*.

Every file created at *src/functions* must have a descriptive name of what kind of functions are defined there, like *http.funct.php* contains all helpers related with HTTP communication.

## Templating

PHP was created as a templating language, this is reason why PHP is so flexible, PHRONT is meant to be used in projects where you don't need a complex layout or a complex interactivity, also some useful helper functions for layouts and partial content (a type of components) are provided.

* Layouts must be defined at *src/layouts* with *.layout.php* extension, if you want to folders inside *src/layouts* you can require it as follows:

```php
// src/layouts/public/header.layout.php
<?php layout('public.header'); ?>

<h1><?=__('Welcome to Phront')?></h1>

// src/layouts/public/footer.layout.php
<?php layout('public.footer'); ?>
```

* Partials must be defined at *src/partials* with *.shared.php* extension, partials can be included as follows:

```php
<?php

// src/partials/alert.shared.php
<?php partial('alert'); ?>

// src/partials/navbar.shared.php
<?php partial('navbar'); ?>

// src/partials/account/navbar.shared.php
<?php partial('account.navbar'); ?>
```

Also an array of data can be passed to layouts and partials as follows:

```php

// at src/layouts/public/header.layout.php
<?php partial('navbar', [
  'logo_name' => 'PHRONT LOGO NAME'
]); ?>

// at src/partials/navbar.shared.php
<nav>
  <a href="/" class="logo"><?=($logo_name ?? 'default value')?></a>
</nav>
```

## Vite & Composer

The idea behind the usage of PHRONT is to avoid the usage of complex build systems and tons of unnecessary dependencies, the idea of PHRONT is not against external libraries, the idea of PHRONT is against unnecessary dependencies, this is the reason why PHRONT comes with an integration with vite and composer.

* Composer is really easy to integrate to any PHP project, you just need to initialize it and then require the autoloader in the file is need it, this enables importing of external dependencies without any trouble, by default composer autoloader is required at the top of *src/ini.php* making it available at any place. For more details of usage check out [composer documentation](https://getcomposer.org/doc/)

* Vite is really powerful to build frontend assets, but the learning curve to learn vite is more hard than composer, by default PHRONT includes all configuration at *vite.config.js* which contains the following settings:
  * All JS & CSS files will be placed at *src/resources/assets* in its own dedicated folder.
  * All static assets will be placed at *src/resources/public* this allows access to static assets from vite server in development.

Vite creates a development server for serve our frontend assets, for this purpose a `ASSET_URL` constant is defined at *src/config.php* to tell to PHRONT the url of vite server.

Vite comes with the following commands

```bash
# starts development server
npm run dev

# build assets
npm run build

# preview build in local environment
npm run preview
```

By default all assets placed at *src/resources* will be processed by vite and then placed at *public/static* for production, at the top of this folder all the files placed at *src/resources/public* will be copied, also all CSS & JS processed files will be placed at *public/static/assets*.

PHRONT provides a helper function to deal with this two environments as follows:

```php
asset('css/app.css');
```

In production the output URL will be `STATIC_URL`+"css/app.css",
(`STATIC_URL` was defined at *src/config.php*).

In development the output URL will be `ASSET_URL`+"css/app.css",
(`ASSET_URL` was defined at *src/config.php*).

For static assets the helper `asset()` will handle automatically the proper url.

## Sanitization

By default PHRONT sanitizes all the incoming data from external sources, also provides at *src/functions/sanitize.func.php* various helpers to sanitize strings, url's and arrays.

## Logging & Debugging

PHRONT provides at *src/functions/debug.func.php* a functions to debug variables during our development process, like `var_dump` or `print_r` built-in functions in PHP, PHRONT debug functions will format the variable output and only works in debug mode if `APP_DEBUG` constant is set to true, if that constant is set to false all debug outputs will not works, hiding sensitive information.

Usage:

```php

// dump
// Outputs any quantity of parameters
_d(1, 2, [true, false, true], ['one' => 1], new Service);

// dump & die
// Outputs and exit
_dd([
  'task' => [
    'id' => 111,
    // ...
  ]
]);

```

In development is really util to outputs some information without affecting the user interface, for this reason PHRONT provides a helper function `_log` to store any message with a timestamp in a file at *storage/logs* as follows:

```php

/*
This message will be stored at storage/logs at a file that starts with the current date like this:
storage/logs/2024_03_16_phront.log
*/
_log('3rd party service is not working because...');

/*
If a second argument is passed, the log message will be appended at storage/logs/myfile.log
*/
_log('some message', 'myfile');

```

Logs will works in production and development, because not affects user interface or exposes sensitive information.

## HTTP

There are a lot of common tasks to deal when a web application is in construction, PHRONT provides a series of useful helper functions defined at *src/functions/http.func.php* to make a json response or get the URL params, set response status, redirections and more.

## Validations

One of the most boring and critical tasks to do is DATA VALIDATION, is really important to do a correct validation of the incoming requests, to guarantee a correct behavour of the system, sometimes is really challenging and other times is really boring, PHRONT provides some useful functions at *src/functions/validations.func.php* to validate the most common scenarios.

A validation function has the following behavour:

* If data is correct a `null` value is returned.
* If data is incorrect a `string` value is returned, with the proper translation.

Example:

```php

// returns null because there is not error
vl_email('hello@hello.com', 'Email Address');

// returns an error with the field passed as second argument with the proper translation
vl_email('hello', 'Email Address');
```

It is also possible to combine many rules like in *src/validations/login.val.php*

```php
function validate_email(mixed $value): ?string
{
	$name = 'Email Address';

	$err = 
		vl_is_required($value, $name) 
		?? vl_is_string($value, $name)
		?? vl_email($value, $name)
		?? null;

  /*
    this sections maybe is not necessary,
    but in some cases you maybe want to do additional validation after the "if".
  */
	if(!is_null($err)) return $err;

	return null;
}
```

## Sessions

PHRONT uses the default session utilities of PHP, for this purpose the initialization is defined at the top of *src/ini.php*.

PHRONT provides support for "flash messages" wich is a utility to store a message when the user is redirected between pages.

```php

// at [POST] /api/login
flash_set('error_email', 'Invalid credentials!');

// at [GET] /login
if( flash_has('error_email') )
{
  echo flash_get('errors_email');
}

```

## Authentication

Authentication can be really complicated and is really important to secure our systems, PHRONT is not meant to be a super complex authentication microservice, is meant to be used as a simple login/registration system with a few features.

By default PHRONT provides some useful helpers at *src/functions/auth.func.php* to login, logout and get authenticated user info and a basic implementation of it.

## HTML Minification & Caching

Static site generators tends to recreate the website but with HTML files, the server is responsible to send proper HTML file in the response.

In the case of Phront you can add the following directives at the top and at the bottom of the page file

```php
<?php html_minify_start(); ?>

<?php layout('public.header'); ?>

<h1><?=__('Page Not Found')?></h1>
<a href="/"><?=__('Go Home')?></a>

<?php layout('public.footer'); ?>

<?php html_minify_end(); ?>
```

`html_minify_start` and `html_minify_end` functions will be responsible for sends the HTML structure minified.

PHRONT provides an easy way to create cached views, you can add the following directives to indicate that you want to cache the current view

```php
<?php cache_start('404'); ?>

<?php layout('public.header'); ?>

<h1><?=__('Page Not Found')?></h1>
<a href="/"><?=__('Go Home')?></a>

<?php layout('public.footer'); ?>

<?php cache_end(); ?>
```

`cache_start` function is responsible to check if cached view exists and then send the proper response to the browser, if an argument is passed it will be used as the name of the cached view, cached views are stored at *storage/cache* and uses the proper naming to identify the language of that view. If no argument is passed to `cache_start` the name of the cached view will be based on the url.

```php

// URL: /posts/algorithms/bubble-sort
cache_start(); // maps to en-algorithms-bubble-sort.html
// URL: /posts/algorithms/dijkstra?section=1&status=22
cache_start(); // maps to en-algorithms-dijkstra-section-1-status-22.html

// Always the same file name
cache_start('404'); // maps to en-404.html


// If the language is set to spanish the cached file names will starts with es-
cache_start(); // maps to es-algorithms-dijkstra-section-1-status-22.html
```

## Multilanguage support

It is really useful to have multi-language support for out web pages, PHRONT provides a basic support for multilanguage feature.

All translations must be placed at *src/resources/lang* and the files must be named as follows `langkey.lang.php` in this case PHRONT is using English as the default language and has Spanish support by default.

For example, at *src/resources/lang/es.lang.php* file, returns an associative array which has in the key the English sentence and in the value the Spanish translation.

The usage of this kind of "static" translations can be used as follows:

```php
// src/resources/lang/es.lang.php
'This is a message' => 'Este es un mensaje'
// src/pages/index.view.php
<h1><?=__('This is a message')?></h1>
```

Note: If the key not exists in the translation file, the key will be returned.

Sometimes is necessary bind a custom value within the message, you can bind it using in the translation key a descriptive name of the message and at the value the message with the formats defined by [sprintf](https://www.php.net/manual/en/function.sprintf) as follows: 

```php
// src/resources/lang/en.lang.php
'errors.required' => '%s field is required'
// src/pages/index.view.php
<h1><?=__l('errors.required', 'Email Address')?></h1>
```

Note: Any number of params can be passed at `__l` function, if the key is not found the key will be returned.

`__l` function by default is going to search in the correct language.

## Database Management

PHRONT keeps really simple the data layer, by default uses SQLITE and has support for MySQL, because PHP has built-in PDO which is a driver that allow us to have the same interface for multiple database engines.

The functions that defines the connection are placed at *src/functions/database.func.php*, this functions must returns a PDO object or a null value in case of failure.

The necessary SQL to generate table schemas are placed at *src/schemas* and must be enumerated is ascending order, this is why in a relational database some instructions must be executed before others, then when is needed to modify a table schema a new file must be created to keep track of all the changes. PHRONT doesn't provide a migration system like Laravel, so the application of SQL statements must be applied manually.

To interact with the database a sort of functions must be defined at *src/tables* and each file must has the name of the table ending with *.db.php* like *users.db.php*, inside this files all defined functions must contains operations to interact with that table.

For example:

* Make schema for tasks

```sql
-- src/schemas/0003_tasks_table.sql
CREATE TABLE tasks(
  id INT AUTO_INCREMENT,
  -- ...other fields
  PRIMARY KEY(id)
);
```

* Write functions to interact with the tasks in the database
```php
// src/tables/tasks.db.php

<?php

// the functions must starts with the name of the table
function tasks_find_by_id(PDO $bd, int $id): ?array { /*... code*/ }
function tasks_store(PDO $bd, array $data): ?array { /*... code*/ }
function tasks_update_by_id(PDO $bd, int $id, array $data): ?array { /*... code*/ }
function tasks_delete_by_id(PDO $bd, int $id): ?array { /*... code*/ }

// the naming of the functions is just a convention is not mandatory.
```

To use it in a page placed at *src/pages* just import *tasks.db.php* as follows:

```php
// src/pages/index.view.php
<?php

require_once TABLE_PATH . '/users.db.php';

// this function is defined at src/functions/database.func.php and
// it is included at src/helpers.php this means database functions
// are globally available
$db = db_sqlite_connect();

if( is_null($db) )
{
  die(__('Service is unavailable'));
}

// ... other stuffs
```

## Deploy PHRONT

There are a lot of shared hosting providers that allows access only to the website folder without any other modification, or maybe some extra services depending on the pricing. PHRONT is meant to be used at a shared hosting, in most cases of local business it is a good choice.

You only need to upload your files to the server, and update some files:

* Don't upload *node_modules*
* Build frontend assets using `npm run build` to generate all frontend assets at *public/static*
* Clean *storage* directory, keep directories structure, but clean all the files inside of it, because this files was generated in development mode.
* Create a new *storage/database/my_new_db.sqlite* because *storage/database/phront.sqlite* is meant to be used in development.
* Update *src/config.php*
  * change `APP_DEBUG` to `false`
  * change `APP_URL` to your domain

If for some reason the provider gives a public folder which is not named as *public* just move all the files inside *public* to this another folder provided by our hosting, for example "www", "html", "public_html", etc...

If your hosting gives some other integrations like Git, SSH, CRON Jobs, you can perfectly integrate it with PHRONT.

<hr>

Code it with <3 by Betozar
