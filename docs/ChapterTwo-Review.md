ChapterTwo Review
=================

Heavy Refactoring
-----------------
In ChapterTwo the team changed the complete domain model again. The initial ideas about the booking procedure were redefined with the help of the domain expert and the Ubiquitous Language. Now, the team has a clear picture of what the shipping application should be responsible for.
You can follow the decisions by browsing through the [issues of ChapterTwo](https://github.com/codeliner/php-ddd-cargo-sample/issues?milestone=1&page=1&state=closed)


Value of using an Ubiquitous Language
-------------------------------------
We don't want repeat Eric Eveans here. Please read his book for detailed information. The team has changed many method names to better reflect the Ubiquitous Language. This is especially true for all PHPUnit test methods. The team switched to a behavior naming convention for test methods. See [issue #13](https://github.com/codeliner/php-ddd-cargo-sample/issues/13) for details.
In addition all getter methods were renamed. It is a rule of thumb that you should avoid the usage of `getProperty` and `setProperty` methods in domain model classes. Find more expressive names to reflect the Ubiquitous Language. For simple property getters that means `$entity->property()` is quite enough cause there is no public setter pendant just a use case specific method that maybe change the property of the entity while processing the use case `$entity->doSomethingThatchangesProperty()`.


Persisting ValueObjects with doctrine - Part 1 
----------------------------------------------
The team now uses doctrine xml mapping files instead of entity annotations. The new files can be found [here](https://github.com/codeliner/php-ddd-cargo-sample/tree/ChapterTwo/module/Application/src/Application/Infrastructure/Persistence/Doctrine/ORM). With that change the domain model is more decoupled of the infrastructure. Another reason is, that doctrine can only map entities to tables, but we have to store ValueObjects in own tables, too. For example the [RouteSpecification](https://github.com/codeliner/php-ddd-cargo-sample/blob/ChapterTwo/module/Application/src/Application/Domain/Model/Cargo/RouteSpecification.php) and the [Itinerary](https://github.com/codeliner/php-ddd-cargo-sample/blob/ChapterTwo/module/Application/src/Application/Domain/Model/Cargo/Itinerary.php). To achieve this, we let doctrine treat them as entities. That means, a RouteSpecification is an immutable ValueObject for our domain. It's public interface is designed that way, but
internally the RouteSpecification has a `private $id` property, a so called [surrogate key](http://en.wikipedia.org/wiki/Surrogate_key), only visible for the class itself and doctrine. The id is auto generated and doesn't play a role in our domain The surrogate key only supports doctrine's requirements that a class needs an identifier when we want to persist it in a table.

Another way to persist ValueObjects is shown with the [Legs](https://github.com/codeliner/php-ddd-cargo-sample/blob/ChapterTwo/module/Application/src/Application/Domain/Model/Cargo/Leg.php) of an Itinerary. We have created a [doctrine custom mapping type](http://doctrine-orm.readthedocs.org/en/latest/cookbook/custom-mapping-types.html) for the [legs](https://github.com/codeliner/php-ddd-cargo-sample/blob/ChapterTwo/module/Application/src/Application/Infrastructure/Persistence/Doctrine/Type/LegsDoctrineType.php) property of an Itinerary, which serializes the legs array. In the [Itinerary xml file](https://github.com/codeliner/php-ddd-cargo-sample/blob/ChapterTwo/module/Application/src/Application/Infrastructure/Persistence/Doctrine/ORM/Application.Domain.Model.Cargo.Itinerary.dcm.xml) the custom mapping type is defined as type of the legs property. Thus the serialized `legs json string` is stored in the `legs column` of the `itinerary table`. ValueObjects that contain just one property can be mapped in a similar fashion.

In one of the next chapters, we will show a third way of persisting ValueObjects, called `embedded ValueObject`. If you can't wait, have a look at this [doctrine pull request](https://github.com/doctrine/doctrine2/pull/835).

Finally, a very good article of [Entities vs Value Objects and Doctrine 2](http://russellscottwalker.blogspot.de/2013/11/entities-vs-value-objects-and-doctrine-2.html) written by Russell Walker. He uses another interesting way to persist ValueObjects.