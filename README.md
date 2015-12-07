# PHP DDD Cargo Sample

PHP 7 port of the cargo sample used in Eric Evans Domain-Driven Design book

[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/prooph/php-ddd-cargo-sample/badges/quality-score.png?s=d68042d97e40904ec369e137b60a1076509298f8)](https://scrutinizer-ci.com/g/prooph/php-ddd-cargo-sample/)
[![Build Status](https://travis-ci.org/prooph/php-ddd-cargo-sample.png?branch=master)](https://travis-ci.org/prooph/php-ddd-cargo-sample)

## PHP Cargo Sample Reloaded

After two years of inactivity a new version of the PHP DDD Cargo Sample is available [2015/12/07].
The new version is a complete rewrite of the cargo sample using cutting edge technology.

##

Goal of the Project
-------------------
We want to show the PHP way of implementing Domain-Driven Design with the help of
the original Cargo sample used in Eric Evans book
`Domain-Driven Design: Tackling Complexity in the Heart of Software`.
This has already been done using java and a C# version is also available.

It is not the one way to apply DDD, but should help you understand the theory
and gives you a starting point. Also see the [Caveats](http://dddsample.sourceforge.net/) of the 
java implementation. The same applies for our version. 

<b>The PHP port is work in progress. Your welcome to fork the repo and help finishing the cargo sample application.</b>

The application layer is based on ZF2 and we use Doctrine2 to persist our aggregates.
This would be a common combination in a large PHP project but both frameworks are not required. They just make our life easier and let us focus on the Domain-Driven Design implementation. Both can be replaced with any other PHP based components.

Iterative Implementation
------------------------
To go with you when you read the book, our sample has a [release of each chapter](https://github.com/prooph/php-ddd-cargo-sample#chapter-overview). So you can
simply `git checkout ChapterOne` and you only get the starting view of the domain
with just to entities `Cargo` and `Voyage`. Our application evolves chapter by chapter
the more knowledge we get about the domain. Each chapter ships with it's own review, where you can find additional information about the implementation, tips and tricks and many more.

Installation
------------
See the [Installation](https://github.com/prooph/php-ddd-cargo-sample/blob/master/docs/installation.md) file.

Useful DDD tools
----------------
Check our collection of [DDD Tools and Libs](https://github.com/prooph/php-ddd-cargo-sample/blob/master/docs/domain-driven-design-tools.md).

Become a member
---------------
If you want to share your experience with other DDD enthusiasts or want to ask a question about DDD then the [DDDinPHP google group](https://groups.google.com/forum/#!forum/dddinphp) is good place to do so.

You can find more DDD stuff like interesting articles and related libraries on the [PhpFriendsOfDdd/state-of-the-union](https://github.com/PhpFriendsOfDdd/state-of-the-union) project.

Project Structure
-----------------
There is no problem if you don't know the structure of a ZF2 application. All the important
parts like the domain and the infrastructure implementation can be found in the [namespace](https://github.com/prooph/php-ddd-cargo-sample/tree/master/module/CargoBackend/src/CargoBackend) of the CargoBackend module.

*Note: Project structure has changed in ChapterFour. In ChapterOne - ChapterThree the domain and infrastructure classes were included in the Application module!*

Behavior Driven Design
----------------------
All features of the application are described in feature files. You can find them in
the [features folder](https://github.com/prooph/php-ddd-cargo-sample/tree/master/features) of the project.
We make use of [Behat](http://behat.org/) and [Mink](http://mink.behat.org/) to test our
business expectations.

You can run the feature tests by navigating to the project root and start the selenium server shipped with the sample app:
`java -jar bin/selenium-server-standalone-2.37.0.jar`
After the server started successfully open another console, navigate to project root again and run Behat with the command `php bin/behat`.

*Note: If it does not work, check that the behat file is executable.

Unit Tests
----------
Unit Tests are of course also available. You can find them in [module/CargoBackend/tests](https://github.com/prooph/php-ddd-cargo-sample/tree/master/module/CargoBackend/tests).
Got to the directory and simply run `phpunit`.

*Note: Project structure has changed in ChapterFour. In ChapterOne - ChapterThree the test classes were included in the Application module!*

Support
-------
If you have any problems with the application please let me know and send me an email `kontakt[at]codeliner[dot]ws` or open a [GitHub issue](https://github.com/prooph/php-ddd-cargo-sample/issues?state=open).
Same applies if you have a question or a feature wish.
Maybe I've missed a concept that you hoped to find in the example.

Chapter Overview
----------------

The chapter overview has moved to the [PHP DDD Cargo Sample project page](http://codeliner.github.io/php-ddd-cargo-sample/#chapter-overview)

Contributing
------------
See the [CONTRIBUTING](https://github.com/prooph/php-ddd-cargo-sample/blob/master/CONTRIBUTING.md) file.

TODO
----
- Provide vagrant support for simple application set up [not started]
- Improve project pages (include reviews, DDD tools, ...) [not started]
- Review of ChapterFour [in progress]
- Implement ChapterFive [not started]
    - Switch to [ValueObjects](https://github.com/nicolopignatelli/valueobjects) and use VOs whenever possible
    - Add reroute Cargo use case
    - Add HandlingEvents
    - Add delivery progress use cases
