# Model Layer

> Model Layer is where the business logic resides.

The models are organized in namespaces (and directories) that describe to which subject they relate to.

In order to understand the **Model Layer** of Pulse is important to make the following terminology clear:

## Domain Objects

A domain object is where lies the domain logic, usually represents an entity in the domain. This is the place where definitions like data validation, behaviors and formulas lives.

## Data Mapper

A data mapper sends the object data to a database, keeping they independent of each other but synced. This is not exactly a class, but the fact that a domain object extends from a mapper, for example: `... extends MongoLid`

## Services

Services are basically components that are triggered to help the business rules to be achieved. An service can be:

- An implementation of sending an email that is triggered by a domain object in a given moment.
- An class that process a spreadsheet or a csv file.
- An class that crops the user picture.
- An class that abstract some database interaction.

Some services (called _"Repositories"_) abstracts the interaction between domain objects and the data mapper methods. They exists in order to simplify the code within the controllers. For example: the creation of a new user account can require alot of inner logic and domain object manipulation using the data mapper functions, but using a Repository Service the controller may simply call one or two methods of the repository.

## References

- [Organizing Snappy - Taylor Otwell](http://blog.userscape.com/post/organizing-snappy)
- [How should a model be structured in MVC - tereÅ¡ko (Stackoverflow)](http://stackoverflow.com/a/5864000)
- [ACL implementation (Side Notes) - tereÅ¡ko (Stackoverflow)](http://stackoverflow.com/a/9685039)
- [ModelViewController - Martin Fowler](http://martinfowler.com/eaaCatalog/modelViewController.html)
- [DomainModel - Martin Fowler](http://martinfowler.com/eaaCatalog/domainModel.html)
- [Repository - Martin Fowler](http://martinfowler.com/eaaCatalog/repository.html)
- [DataMapper - Martin Fowler](http://martinfowler.com/eaaCatalog/dataMapper.html)
