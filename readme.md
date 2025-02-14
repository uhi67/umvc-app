Application template for UMVC framework
=======================================

v1.0 -- 2025-01-07 

Requirements
------------

- git
- composer (see https://getcomposer.org)
- php >= 8.2

Installation
------------

How to start a new application project

- `composer create-project --prefer-source uhi67/umvc-app umvc-app`

OR if Docker is availabla

- `clone uhi67/umvc-app`
- `./build-dev-stack.sh` # Run from WSL2 Linux prompt with root user and having a valid ssh session.

Next steps
----------

1. Create controller classes with actions in `controllers` directory
2. Create an empty database and put its configuration into `config/config.php`
3. Create data model classes in `models` directory and corresponding database tables with migrations
4. Create PHTML views in `views/` directory organized by controllers and actions

More information about the UMVC framework
-----------------------------------------

See https://github.com/uhi67/umvc/blob/master/readme.md

Change log
----------

## 1.0 -- 2025-01-07

The first release