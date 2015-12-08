# PHP DDD Cargo Sample

PHP 7 port of the cargo sample used in Eric Evans Domain-Driven Design book

[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/codeliner/php-ddd-cargo-sample/badges/quality-score.png?s=d68042d97e40904ec369e137b60a1076509298f8)](https://scrutinizer-ci.com/g/codeliner/php-ddd-cargo-sample/)
[![Build Status](https://travis-ci.org/codeliner/php-ddd-cargo-sample.png?branch=master)](https://travis-ci.org/codeliner/php-ddd-cargo-sample)

## Cargo Sample Reloaded

After two years of inactivity a new version of the PHP DDD Cargo Sample is available [2015/12/07].
The new version is a complete rewrite of the cargo sample using cutting edge technology.

### Sponsoring
This brand new cargo sample version is sponsored by prooph software GmbH. You can follow us on [twitter](https://twitter.com/prooph_software)

### tl;dr
Click [here](https://github.com/codeliner/php-ddd-cargo-sample/pull/22#issuecomment-162734730) :smile:

### What Is New?

- [x] PHP 7 with strict scalar type hints
- [x] PSR-7 middleware layer using [zend-expressive](https://github.com/zendframework/zend-expressive)
- [x] Doctrine ORM ^2.5 [Embeddables](http://doctrine-orm.readthedocs.org/projects/doctrine-orm/en/latest/tutorials/embeddables.html)
- [x] PHPUnit ^5.0
- [x] Behat ^3.0
- [x] Single Page UI using [riot.js](http://riotjs.com/)

## Goal of the Project

We want to show the PHP 7 way of implementing Domain-Driven Design with the help of
the original Cargo sample used in Eric Evans book
`Domain-Driven Design: Tackling Complexity in the Heart of Software`.
This has also been done using Java, C#, Ruby and other programming languages.

It is not the one way to apply DDD and only covers the tactical part of DDD. 
However, the cargo sample should help you understand the theory
and gives you a starting point. Also see the [Caveats](http://dddsample.sourceforge.net/) of the 
java implementation. The same applies for our version. 

## Installation
See the [Installation](https://github.com/codeliner/php-ddd-cargo-sample/blob/master/docs/installation.md) file.

## Structure
The [annotated project overview](https://github.com/codeliner/php-ddd-cargo-sample/blob/master/docs/structure.md)
gives you an idea of the system structure.

## Support
If you have any problems with the application please open a [GitHub issue](https://github.com/codeliner/php-ddd-cargo-sample/issues?state=open).
Same applies if you have a question or a feature wish.

## Contributing
Contributions of any kind are welcome. The PHP 7 DDD cargo sample aims to help people understand the tactical design part of DDD.
So we'd be very happy if you tell your friends about it, link it in discussions and mention it on twitter.
If you've found a bug or have an idea for an improvement, just submit a PR like usual.

## Become A Member
If you want to share your experience with other DDD enthusiasts or want to ask a question about DDD then the [DDDinPHP google group](https://groups.google.com/forum/#!forum/dddinphp) is good place to do so.

You can find more DDD stuff like interesting articles and related libraries on the [PhpFriendsOfDdd/state-of-the-union](https://github.com/PhpFriendsOfDdd/state-of-the-union) project.

## Behavior Driven Design
All features of the application are described in feature files. You can find them in
the [features folder](https://github.com/codeliner/php-ddd-cargo-sample/tree/master/features) of the project.
We make use of [Behat](http://behat.org/) and [Mink](http://mink.behat.org/) to test our
business expectations.

You can run the feature tests by navigating to the project root and start the selenium server shipped with the sample app:
`java -jar bin/selenium-server-standalone-2.46.0.jar`
After the server started successfully open another console, navigate to project root again and run Behat with the command `php bin/behat`.

*Note: If it does not work, check that the behat file is executable.

## Unit Tests
Unit Tests are of course also available. You can find them in [CargoBackend/tests](https://github.com/codeliner/php-ddd-cargo-sample/tree/master/CargoBackend/tests).
Got to the directory and simply run `phpunit`.
