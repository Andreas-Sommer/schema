.. include:: ../Includes.txt

.. index:: API

.. _api:

=============
Using The API
=============

Target group: **Developers**

.. contents:: Table of Contents
   :depth: 3
   :local:


Introduction
============

With the extension's API you can define the structured markup with PHP. For
example, create a class which gets an Extbase model as input and defines the
markup. Then instantiate the class in an action of your controller.

Each type model class in the PHP namespace :php:`Brotkrueml\Schema\Model\Type`
inherits from the abstract class
:php:`Brotkrueml\Schema\Core\Model\AbstractType` which defines methods to set
and get the properties of a model.

There are currently over 600 models available.

Starting With An Example
========================

Let's start with a simple example. Imagine you describe a
`person <https://schema.org/Person>`__ on a plugin's detail page that you want
to enrich with structured markup. First you have to create the schema model::

   $person = new \Brotkrueml\Schema\Model\Type\Person();

As you see, the schema type ``Person`` maps to the model :php:`Person`. You can
use every accepted type of the
`schema.org vocabulary <https://schema.org/docs/full.html>`__.

Surely you will need to add some properties::

   $person
      ->setId('http://example.org/#person-42')
      ->setProperty('givenName', 'John')
      ->setProperty('familyName', 'Smith')
      ->setProperty('gender', 'http://schema.org/Male');
   ;

That was easy ... let's go on and define an event the person attends::

   $event = (new \Brotkrueml\Schema\Model\Type\Event())
      ->setProperty('name', 'Fancy Event')
      ->setProperty('image', 'https:/example.org/event.png')
      ->setProperty('url', 'https://example.org/')
      ->setProperty('isAccessibleForFree', true)
      ->setProperty('sameAs', 'https://twitter.com/fancy-event')
      ->addProperty('sameAs', 'https://facebook.com/fancy-event')
   ;

Now we have to connect the two types together::

   $person->setProperty('attendee', $event);

The defined models are ready to embed on the web page. The schema manager does
that for you::

   $schemaManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
      \Brotkrueml\Schema\Manager\SchemaManager::class
   );
   $schemaManager->addType($person);


That's it ... if you call the according page the structured markup is embedded
automatically into the head section:

.. code-block:: json

   {
      "@context": "http://schema.org",
      "@type": "Person",
      "@id": "http://example.org/#person-42",
      "givenName": "John",
      "familyName": "Smith",
      "gender": "http://schema.org/Male",
      "attendee": {
         "@type": "Event",
         "name": "Fancy Event",
         "image": "https://example.org/event.png",
         "url": "https://example.org",
         "isAccessibleForFree": "http://schema.org/True",
         "sameAs": ["https://twitter.com/fancy-event", "https://facebook.com/fancy-event"]
      }
   }

.. index::
   single: Model API
   seealso: Model API; API
   seealso: Model API; Model

The Model In-Depth
==================

Each type model, like `Thing`, `Person` or `Event`, must implement the interface
:php:`Brotkrueml\Schema\Core\Model\TypeInterface`. For convenience, a type
model can also extend the abstract class
:php:`Brotkrueml\Schema\Core\Model\AbstractType` which implements every needed
method.

Two other interfaces are available, they are used to "tag" a type model class as
a "special type" and don't require the implementation of additional methods:

- :php:`Brotkrueml\Schema\Core\Model\WebPageTypeInterface` for a
  :ref:`web page type <webpage-types>`.
- :php:`Brotkrueml\Schema\Core\Model\WebPageElementTypeInterface` for a
  `web page element type <https://schema.org/WebPageElement>`_.

These interfaces can be useful when you want to :ref:`extend the
vocabulary <extending-vocabulary>`.

.. figure:: ../Images/Developer/TypeModels.png
   :alt: Inheritance of the type models

   Inheritance of the type models

Each type model delivered with this extension extends the :php:`AbstractType`
class.


Available Type Model Methods
----------------------------

The type models expose several methods:

:php:`->setId(string $id)`
~~~~~~~~~~~~~~~~~~~~~~~~~~

The method sets the unique ID of the model. With the ID, you can cross-reference
types on the same page or between different pages (and even between different
web sites) without repeating all the properties.

It is common to use an
`IRI <https://en.wikipedia.org/wiki/Internationalized_Resource_Identifier>`__ as
ID like in the above example. Please keep in mind that the ID should be
consistent between changes of the properties, e.g. if a person marries and the
name is changed. The person is still the same, so the IRI should be.

The IRI is no URL, so it is acceptable to give a "404 Not Found" back if you
call it in a browser.

Parameter
   :php:`string $id`: The unique id to set.

Return value
   Reference to the model itself.


:php:`->getId()`
~~~~~~~~~~~~~~~~

Gets the id of the type model.

Parameter
   none

Return value
   A previously set id or null (if not defined).


:php:`->setProperty(string $propertyName, $propertyValue)`
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Call this method to set a property or overwrite a previously one.

Parameters
   :php:`string $propertyName`
      The property name to set. If the property does not exist in the model,
      an exception is thrown.
   :php:`string|array|bool|AbstractType|null $propertyValue`
      The value of the property to set. This can be a string, a boolean, another
      model or an array of strings, booleans or models. Also null is possible to
      clear the property value.

Return value
   Reference to the model itself.


:php:`->addProperty(string $propertyName, $propertyValue)`
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Call this method if you want to add a value to an existing one. In the example
above, you can see that :php:`addProperty()` is used to add a second value to
the :php:`sameAs` property.

Calling the :php:`addProperty()` method on a property that has no value assigned
has the same effect as calling :php:`setProperty()`. So you can safely use it,
e.g. in a loop, to set some values on a property.

Parameters
   :php:`string $propertyName`
      The property name to set. If the property does not exist in the model, an
      exception is thrown.
   :php:`string|array|bool|AbstractType|null $propertyValue`
      The value of the property to set. This can be a string, a boolean, another
      model or an array of strings, booleans or models. Also null is possible to
      clear the property value.

Return value
   Reference to the model itself.


:php:`->setProperties(array $properties)`
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Set multiple properties at once.

Parameter
   :php:`array $properties`
      The properties to set. The key of the array is the property name, the
      value is the property value. Allowed as values are the same as with the
      method :php:`->setProperty()`.

Return value
   Reference to the model itself.


:php:`->getProperty(string $propertyName)`
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Get the value of a property.

Parameter
   :php:`string $propertyName`
      The property name to get the value from. If the property name does not
      exist in the model, an exception is thrown.

Return value
   The value of the property (string, bool, model, array of strings, array of
   models, null).


:php:`->hasProperty(string $propertyName)`
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Check whether the property name exists in a particular model.

Parameter
   :php:`string $propertyName`
      The property name to check.

Return value
   :php:`true`, if the property exists and :php:`false`, otherwise.


:php:`->clearProperty(string $propertyName)`
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Resets the value of the property (set it to :php:`null`).

Parameter
   :php:`string $propertyName`
      The property name to set. If the property does not exist in the model, an
      exception is thrown.

Return value
   Reference to the model itself.


:php:`->getPropertyNames()`
~~~~~~~~~~~~~~~~~~~~~~~~~~~

Get the names of all properties of the model.

Return value
   Array of all property names of the model.


.. index:: Schema Manager

.. _api-schema-manager:

Schema Manager
==============

The Schema Manager (class :php:`Brotkrueml\Schema\Manager\SchemaManager`) –
well – manages the type models and prepares them for embedding into the web
page.

The class exposes the following methods:

:php:`->addType(TypeInterface $type)`
-------------------------------------

Adds the given type model to the Schema Manager for inclusion on the web page.

Parameter
   :php:`TypeInterface $type`
      The type model class with the set properties. This can be also
      "special" types, like a `WebPage` or a `BreadcrumbList`.

Return value
   Reference to itself.


:php:`hasWebPage()`
-------------------

Checks, if a :ref:`web page type <webpage-types>` is already available.

Parameter
   none

Return value
   :php:`true`, if a web page type is available, otherwise :php:`false`


.. _api-schema-manager-addmainentityofwebpage:

:php:`addMainEntityOfWebPage(TypeInterface $mainEntity)`
--------------------------------------------------------

Adds a :ref:`main entity <main-entity-of-web-page>` to the web page.

Parameter
   :php:`TypeInterface $mainEntity`
      The type model to be added.

Return value
   Reference to itself.



Other Useful APIs
=================

.. index:: Boolean

Boolean Data Type
-----------------

Boolean property values are mapped to the according schema terms
``http://schema.org/True`` or ``http://schema.org/False``. You can also use
the :php:`Brotkrueml\Schema\Model\DataType\Boolean` class yourself. It exposes
two public constants:

:php:`::FALSE`
   Has the value ``http://schema.org/False``.

:php:`::TRUE`
   Has the value ``http://schema.org/True``.

and one static method:

:php:`::convertToTerm(bool $value): string`
   This method returns the according schema term.


.. index::
   single: Type list
   seealso: Type list; API

.. _api-list-of-types:

List Of Types
-------------

If you need a list of the available types or a subset of them, you can call
methods on the :php:`Brotkrueml\Schema\Registry\TypeRegistry` class. As this is
a singleton, instantiate the class with::

   $typeRegistry = GeneralUtility::makeInstance(\Brotkrueml\Schema\Registry\TypeRegistry::class);

or use dependency injection in TYPO3 v10+.


:php:`->getTypes()`
~~~~~~~~~~~~~~~~~~~

Get all available type names.

Parameter
   none

Return value
   Array, sorted alphabetically by type name.


:php:`->getWebPageTypes()`
~~~~~~~~~~~~~~~~~~~~~~~~~~

Get the `WebPage <https://schema.org/WebPage>`__ type and its descendants.

Parameter
   none

Return value
   Array, sorted alphabetically by type name.


:php:`->getWebPageElementTypes()`
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Get the `WebPageElement <https://schema.org/WebPageElement>`__ type and its
descendants.

Parameter
   none

Return value
   Array, sorted alphabetically by type name.


.. _api-typesprovider-getcontenttypes:

:php:`->getContentTypes()`
~~~~~~~~~~~~~~~~~~~~~~~~~~

The types useful for an editor are returned as an array, sorted alphabetically.

The following types are filtered out:

- ``BreadcrumbList``
- ``WebPage`` and descendants
- ``WebPageElement`` and descendants
- ``WebSite``

Parameter
   none

Return value
   Array, sorted alphabetically by type name.


.. index:: Deprecations

.. _api-deprecations:

Deprecations
============

:php:`Brotkrueml\Schema\Core\Model\AbstractType->isEmpty()`
-----------------------------------------------------------

Deprecated since version
   1.7.0

Will be removed in version
   2.0.0

Alternative
   None. If you need it use
   :php:`Brotkrueml\Schema\Core\Model\AbstractType->getPropertyNames()`
   and loop over the property names with
   :php:`Brotkrueml\Schema\Core\Model\AbstractType->getProperty()`.


:php:`Brotkrueml\Schema\Manager\SchemaManager->setMainEntityOfWebPage()`
------------------------------------------------------------------------

Deprecated since version
   1.4.1

Will be removed in version
   2.0.0

Alternative
   Use :php:`Brotkrueml\Schema\Manager\SchemaManager->addMainEntityOfWebPage()`
   instead. See the :ref:`API <api-schema-manager-addmainentityofwebpage>`.


:php:`Brotkrueml\Schema\Provider\TypesProvider` class
-----------------------------------------------------

Deprecated since version
   1.7.0

Will be removed in version
   2.0.0

Alternative
   Use :php:`Brotkrueml\Schema\Registry\TypeRegistry` which is now a singleton
   and can be instantiated with :php:`GeneralUtility::makeInstance()` or in
   TYPO3 v10+ via dependency injection. See section :ref:`api-list-of-types`.
