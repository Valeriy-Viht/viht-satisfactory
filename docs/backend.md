# Backend Service

A service designed to process HTTP requests and WS connections.

## Goal

Provide HTTP and Event Driven API for data management.

## Functional

- Provides access to the data warehouse
- Manages sessions, performs authentication verification
- Keeps a pool of active WS connections and distributes tasks to microservices.


## Modules

- `src\Modules\DI` : provides lightweight object lifecycle management and dependency injection.
- `src\Modules\Database`: provides abstract access to storage, hiding a specific DBMS from client modules.
- `src\Modules\Repository`: IRepository provides an abstract set of methods hiding the specific implementation of queries in the database. 
- `src\Modules\Redis`: provides access to in-memory storage for modules `Auth`, `Data`.
- `src\Modules\Controller`: provides convenient management of HTTP API controllers and their registration in the Router.


## Interaction

Tasks come from the backend service over a TCP socket and are distributed among child handler processes via ICP.