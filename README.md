php-ddd-cargo-sample
====================

PHP 5.4+ port of the cargo sample used in Eric Evans Domain-Driven Design book

[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/codeliner/php-ddd-cargo-sample/badges/quality-score.png?s=d68042d97e40904ec369e137b60a1076509298f8)](https://scrutinizer-ci.com/g/codeliner/php-ddd-cargo-sample/)
[![Build Status](https://travis-ci.org/codeliner/php-ddd-cargo-sample.png?branch=master)](https://travis-ci.org/codeliner/php-ddd-cargo-sample)

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
To go with you when you read the book, our sample has a [release of each chapter](https://github.com/codeliner/php-ddd-cargo-sample#chapter-overview). So you can
simply `git checkout ChapterOne` and you only get the starting view of the domain
with just to entities `Cargo` and `Voyage`. Our application evolves chapter by chapter
the more knowledge we get about the domain. Each chapter ships with it's own review, where you can find additional information about the implementation, tips and tricks and many more.

+ [Installation](https://github.com/codeliner/php-ddd-cargo-sample/blob/master/docs/installation.md)
+ [DDD Tools and Libs](https://github.com/codeliner/php-ddd-cargo-sample/blob/master/docs/domain-driven-design-tools.md)

Project Structure
-----------------
There is no problem if you don't know the structure of a ZF2 application. All the important
parts like the domain and the infrastructure implementation can be found in the [namespace](https://github.com/codeliner/php-ddd-cargo-sample/tree/master/module/Application/src/Application) of the application module.

Behavior Driven Design
----------------------
All features of the application are described in feature files. You can find them in
the [features folder](https://github.com/codeliner/php-ddd-cargo-sample/tree/master/features) of the project.
We make use of [Behat](http://behat.org/) and [Mink](http://mink.behat.org/) to test our
business expectations.

Unit Tests
----------
Unit Tests are of course also available. You can find them in [module/Application/tests/PHPUnit](https://github.com/codeliner/php-ddd-cargo-sample/tree/master/module/Application/tests/PHPUnit).
Got to the directory and simply run `phpunit`.

Support
-------
If you have any problems with the application please let me know and send me an email `kontakt[at]codeliner[dot]ws` or open a [GitHub issue](https://github.com/codeliner/php-ddd-cargo-sample/issues?state=open).
Same applies if you have a question or a feature wish.
Maybe I've missed a concept that you hoped to find in the example.

Chapter Overview
----------------

###ChapterOne
`git checkout ChapterOne`

Chapter One release contains the first draft of the Cargo DDD model.
It contains the Entities `Cargo` and `Voyage` and also an `Application BookingService` that works with an `overbooking policy`
to allow the booking of a Cargo even when the Voyage has not enough free capacity.

[ChapterOne Review](https://github.com/codeliner/php-ddd-cargo-sample/blob/master/docs/ChapterOne-Review.md)
###ChapterTwo
`git checkout ChapterTwo`

In Chapter Two we learn the importance of the Ubiquitous Language. With it's help the team works out a Cargo Router and redefines the use cases for the Shipping Application. The `Application BookingService` is replaced with a `Application RoutingService`, cause the system focuses on planing an `Itinerary` for a `Cargo` that satisfies a `RouteSpecification`.

[ChapterTwo Review](https://github.com/codeliner/php-ddd-cargo-sample/blob/master/docs/ChapterTwo-Review.md)

###ChapterThree
`git checkout ChapterThree`

ChapterThree is about Model-Driven Design.

> "Design a portion of the software system to reflect the domain model in a very literal way, so that
> mapping is obvious. Revisit the model and modify it to be implemented more naturally in software,
> even as you seek to make it reflect deeper insight into the domain. Demand a single model that
> serves both purposes well, in addition to supporting a robust UBIQUITOUS LANGUAGE.
> Draw from the model the terminology used in the design and the basic assignment of responsibilities.
> The code becomes an expression of the model, so a change to the code may be a change to the
> model. Its effect must ripple through the rest of the project's activities accordingly."
>
> -- Eric Evans: Domain-Driven Design: Tackling Complexity in the Heart of Software

[ChapterThree Review](https://github.com/codeliner/php-ddd-cargo-sample/blob/master/docs/ChapterThree-Review.md)
