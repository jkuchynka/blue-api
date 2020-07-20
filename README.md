
## About Blue API

This is a starter kit that uses Laravel and other composer packages to help you kick-start your next killer API. This is a WIP and things are changing rapidly as we experiment and find the sweet spot that addresses our goals. See Our Goals section to learn more!.

## Modular

Using a modular structure, Blue API enables you to develop a module and use it across multiple projects. We've extended Laravel's artisan commands to allow for make commands to respect module directories. A handy module:make command is in the works.

### Config

A module can be enabled in the config/modules.php file, where you can also override modules' config settings. Each module should provide their own moduleName.config.yaml file, which provides some settings, as well as their routes. See the built in module configs for some good examples.

## Current Modules

### Auth

This handles Authentication and Authorization. Users can login, logout, register, reset their password. This also handles setting up a role and permission system that handles access to routes.

### Base

Base is the core module of Blue API, which does most of the heavy lifting, and contains all the base classes, traits and support classes for Blue and it's modules. This may eventually be extracted into a composer package, but it does a lot and there's a lot to modify here if needed. 

### Messages

Handles contact messages which store a copy in the database and sends out emails. Can be extended to handle a user messaging system.

### Users

Manages users. A great resource for an example of a fully built out module with most of what you might need in your module.

## Goals

### SSOT

Where possible, we want to have a single source of truth (definitions, schema, logic, etc...)

### DRY

Similar to SSOT, we shouldn't have to repeat any sort of code logic ever. Having to do so makes for more work in all and future stages of development.

### Testing

All code should have 100% test coverage, and be easily testable.

### API -> Client

The API should provide an updated schema to the client that can be used to generate forms, validation, tables and queries etc.

## License

Blue API is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
