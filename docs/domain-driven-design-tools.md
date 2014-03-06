Domain-Driven Design Tools for PHP
==================================

We have listed a selection of useful tools and libraries that help you implementing Domain-Driven Design patterns.
This list is not meant to be complete. It is just a choice of personal favorites.
If you think we have missed an important tool, than please provide a pull request with your addition or simply open an [issue](https://github.com/codeliner/php-ddd-cargo-sample/issues).

DDD Interfaces
--------------

###codeliner/shared-domain-set
Collection of common DDD interfaces like EntityInterface, ValueObjectInterface, DomainEventInterface

[GitHub Repository](https://github.com/codeliner/shared-domain-set)


ValueObjects
------------

###nicolopignatelli/valueobjects
A PHP 5.3+ library/collection of classes aimed to help developers with domain driven development and the use of immutable objects.

[GitHub Repository](https://github.com/nicolopignatelli/valueobjects)


Little Helper
-------------

###beberlei/assert
A simple php library which contains assertions and guard methods for input validation. Useful to guard your domain objects.

[GitHub Repository](https://github.com/beberlei/assert)

###codeliner/php-equalsbuilder
EqualsBuilder for PHP. Ease the comparison of ValueObject properties within ValueObjectInterface#sameValueAs implementations.
See our [RoteSpecification#sameValueAs](https://github.com/codeliner/php-ddd-cargo-sample/blob/master/module/Application/src/Application/Domain/Model/Cargo/RouteSpecification.php) as an example.

[GitHub Repository](https://github.com/codeliner/php-equalsbuilder)

Storage
-------

###doctrine/doctrine2
Doctrine 2 is an object-relational mapper (ORM) for PHP 5.3.2+ that provides transparent persistence for PHP objects. It fits well with DDD and helps you implement the repository pattern. See the various examples in our cargo shipping system.

[GitHub Repository](https://github.com/doctrine/doctrine2)

###doctrine/mongodb-odm
The Doctrine MongoDB ODM project is a library that provides a PHP object mapping functionality for MongoDB. If you prefer using MongoDB as storage system, this library helps you implement the repository pattern like doctrine ORM do for Sql DBMS.

[GitHub Repository](https://github.com/doctrine/mongodb-odm)

###doctrine/couchdb-odm
A Document Mapper based on CouchDB. If you prefer using CouchDB as storage system, this library helps you implement the repository pattern like doctrine ORM do for Sql DBMS.

[GitHub Repository](https://github.com/doctrine/couchdb-odm)