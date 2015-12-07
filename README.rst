cymbaline
=========
.. image:: https://api.travis-ci.org/nerandell/cymbaline.svg?branch=master
    :target: https://travis-ci.org/nerandell/cymbaline
|    
`cymbaline` is yet another PHP web service framework. It follows MVC pattern 
and makes development of web applications easy by including commonly used tasks
in the framework itself to reduce effort and time taken for development.

Getting Started
---------------
- PHP 5.3.x is required
- Install Composer_
- Setup URL rewriting so that all requests are handled by index.php
.. _composer: https://getcomposer.org/

Installation
------------
- Get Composer
- Require cymbaline with  ``php composer.phar require cymbaline/cymbaline``
- Add the following to your application's main PHP file: ``require 'vendor/autoload.php';``

You can also add the following to an existing ``composer.json`` file :  ``"cymbaline/cymbaline": "*"``. 
A sample ``composer.json`` would look like this:

.. code-block:: json

    {
        "name": "cymbaline/cymbaline_demo",
        "description": "Demo for using cymbaline",
        "authors": [
            {
                "name": "Ankit Chandawala",
                "email": "ankitchandawala@gmail.com"
            }
        ],
        "require": {
            "cymbaline/cymbaline": "@dev"
        },
        "minimum-stability": "dev"
    }

``cymbaline`` requires several libraries to work.

- Klein_ is used for routing.
- It uses Eloquent_ to work with your databases.
- Twig_ is used as a templating engine for rendering views.
.. _Klein: https://github.com/chriso/klein.php

.. _Eloquent: http://laravel.com/docs/5.0/eloquent
.. _Twig: http://twig.sensiolabs.org/

Usage
-----
To see a sample app, you can check a simple demo here_.

.. _here: https://github.com/nerandell/cymbaline_demo

Once ``cymbaline`` is installed, start routing all your requests to ``index.php``.
Here is a sample nginx configuration to route the requests

.. code::

    location / {
                try_files $uri $uri/ /index.php;
                root   /path_to_your_root_dir;
                index  index.html index.htm index.php;
            }

Add the following lines to our ``index.php`` file : ``require 'vendor/autoload.php';``

``cymbaline`` is based on MVC_ design pattern. You can start defining your models, 
controllers and views and ``cymbaline`` will stitch it all for you using short and concise code
to reduce the development times needed while building a web application.

You app code should reside in top-level directory named ``app``. Then you can start adding
your models, contollers and views. Typically your directory structure would look like this:

.. code::

    app
    ├── config
    │   └── database.php
    ├── controllers
    │   ├── CompanyController.php
    │   └── UserController.php
    ├── models
    │   ├── Company.php
    │   └── User.php
    ├── routes.php
    └── views
        └── index.html

.. _MVC : https://msdn.microsoft.com/en-us/library/ff649643.aspx

The models that you define reside in the ``app/models`` directory. 
To create a model, you have to extend from ``BaseModel`` class which is provided 
by ``cymbaline``

.. code-block:: python

    <?php
    
    use Cymbaline\BaseModel;
    
    class User extends BaseModel
    {
    
    }
    
``BaseModel`` internally uses ``Model`` class from ``Eloquent`` and
same options are available for configuration. Check out Eloquent documentation_
for more information. 

.. _documentation: http://laravel.com/docs/5.1/eloquent

``cymbaline`` picks up your database configuration from ``config/database.php``.
Your database file will look like this:

.. code-block:: php

        <?php
        
        $connection = [
            'host' => 'your-host',
            'driver'    => 'mysql',
            'database'  => 'your-database',
            'username'  => 'your-user',
            'password'  => 'your-password',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => ''
        ];



Now define a controller named ``UserController`` directory like this:

.. code-block:: python

    <?php
    
    use Cymbaline\Controller;
    
    class UserController extends Controller
    {
    
    }

You can also define a view in ``app/views/`` directory which will be rendered using ``Twig``.

Once, you add a model and an associated controller, ``cymbaline`` can automatically create
RESTful crud api for you. 

For example, to create a new user:

.. code-block :: bash

    $ curl -X POST -H "Content-Type: application/json" -d '{"name": "User1"}' 'http://localhost:8080/user'
    
To retrive a user:

.. code-block :: bash

    $ curl -X GET -H 'http://localhost:8080/user/1'
  
will give the output:

.. code-block:: json

    {
    	"id": 1,
    	"name": "User1",
    	"created_at": "2015-12-06 03:47:59",
    	"updated_at": "2015-12-06 03:47:59"
    }

However, it is entirely upto you to define which apis you want and 
you can override the default behaviour.

You can define your own routes too. Custom routes are defined in ``app/routes.php`` directory.
Here is a sample route added. ``cymbaline`` uses Klein for routing and the routing options.


.. code-block:: php

    use Cymbaline\Route;
    
    Route::addRoute('get', '/hello/[:id]', function($request) {
        $controller = new UserController();
        $controller->test_custom_route($request->id);
    });

Then add a method to the controller:

.. code-block:: php

    <?php
    
    use Cymbaline\Controller;
    
    class UserController extends Controller
    {
        public function test_custom_route($id)
        {
            $user = call_user_func(array($this->_model, 'find'), $id);
            $this->renderView('index.html', array('name'=>$user->name));
        }
    }

``renderView`` method uses Twig_ to render view.

.. _Twig: http://twig.sensiolabs.org/

Your index.html will look like this:

.. code-block :: html

    <html lang="en" xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta name="generator" content=
        "HTML Tidy for Linux/x86 (vers 25 March 2009), see www.w3.org" />
        <meta charset="UTF-8" />
    
        <title>Title</title>
    </head>
    
    <body>
        Hello {{name}}
    </body>
    </html>
  
License
-------
``cymbaline`` is offered under the MIT license.

Source code
-----------
The latest developer version is available in a github repository:
https://github.com/nerandell/cymbaline

What does Cymbaline mean?
-------------------------
Cymbaline is a Pink Floyd song from the album, Soundtrack from the Film More.
