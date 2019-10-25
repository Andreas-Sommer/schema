.. include:: ../Includes.txt

.. index:: API

.. _api:

=============
Using the API
=============

Target group: **Developers**

With the extension's API you can define the structured markup with PHP. For example, create a class which gets an
Extbase model as input and defines the markup. Then instantiate the class in an action of your controller.

Each type model class in the PHP namespace :php:`Brotkrueml\Schema\Model\Type` inherits from the abstract class
:php:`Brotkrueml\Schema\Core\Model\AbstractType` which defines methods to set and get the properties of a model.

There are currently over 600 models available.

Starting with an Example
========================

Let's start with a simple example. Imagine you describe a `person <https://schema.org/Person>`__ on a plugin's detail
page that you want to enrich with structured markup. First you have to create the schema model:

.. code-block:: php

   $person = new \Brotkrueml\Schema\Model\Type\Person();

As you see, the schema type ``Person`` maps to the model :php:`Person`. You can use every accepted type of the
`schema.org vocabulary <https://schema.org/docs/full.html>`__.

Surely you will need to add some properties:

.. code-block:: php

   $person
      ->setId('http://example.org/#person-42')
      ->setProperty('givenName', 'John')
      ->setProperty('familyName', 'Smith')
      ->setProperty('gender', 'http://schema.org/Male');
   ;

That was easy ... let's go on and define the company the person works for:

.. code-block:: php

   $corporation = (new \Brotkrueml\Schema\Model\Type\Corporation())
      ->setProperty('name', 'Acme Ltd.')
      ->setProperty('image', 'https:/example.org/logo.png')
      ->setProperty('url', 'https://example.org/')
      ->setProperty('sameAs', 'https://twitter.com/acme')
      ->addProperty('sameAs', 'https://facebook.com/acme')
   ;

Now we have to connect the two types together:

.. code-block:: php

   $person->setProperty('worksFor', $corporation);

The defined models are ready to embed on the web page. The schema manager does that for you:

.. code-block:: php

   $schemaManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
      \Brotkrueml\Schema\Manager\SchemaManager::class
   );
   $schemaManager->addType($person);


That's it ... if you call the according page the structured markup is embedded automatically into the head section:

.. code-block:: json

   {
      "@context": "http://schema.org",
      "@type": "Person",
      "@id": "http://example.org/#person-42",
      "givenName": "John",
      "familyName": "Smith",
      "gender": "http://schema.org/Male",
      "worksFor": {
         "@type": "Corporation",
         "name": "Acme Ltd.",
         "image": "https://example.org/logo.png",
         "url": "https://example.org",
         "sameAs": ["https://twitter.com/acme", "https://facebook.com/acme"]
      }
   }

.. index::
   single: Model API
   seealso: Model API; API
   seealso: Model API; Model

The Model In-Depth
==================

The type models expose several methods:

:php:`->setId(string $id)`
--------------------------

The method sets the unique ID of the model. With the ID, you can cross-reference types on the same page or between
different pages (and even between different web sites) without repeating all the properties.

It is common to use an `IRI <https://en.wikipedia.org/wiki/Internationalized_Resource_Identifier>`__ as ID like in the
above example. Please keep in mind that the ID should be consistent between changes of the properties, e.g. if a person
marries and the name is changed. The person is still the same, so the IRI should be.

The IRI is no URL, so it is acceptable to give a "404 Not Found" back if you call it in a browser.

:aspect:`Parameter`

   * :php:`string $id`: The unique id to set.

:aspect:`Return value`

   Reference to itself.


:php:`->getId()`
----------------

:aspect:`Return value`

   A previously set id or null (if not set).


:php:`->setProperty(string $propertyName, $propertyValue)`
----------------------------------------------------------

Call this method to set a property or overwrite a previously one.

:aspect:`Parameters`

   * :php:`string $propertyName`: The property name to set. If the property does not exist in the model, an
     exception is thrown.
   * :php:`string|array|AbstractType|null $propertyValue`: The value of the property to set. This can be a string, another
     model or an array of strings or models. Also null is possible to clear the property value.

:aspect:`Return value`

   Reference to the model itself.


:php:`->addProperty(string $propertyName, $propertyValue)`
----------------------------------------------------------

Call this method if you want to add a value to an existing one. In the example above, you can see that :php:`addProperty()`
is used to add a second value to the :php:`sameAs` property.

Calling the :php:`addProperty()` method on a property that has no value assigned has the same effect as calling
:php:`setProperty()`. So you can safely use it, e.g. in a loop, to set some values on a property.

:aspect:`Parameters`

   * :php:`string $propertyName`: The property name to set. If the property does not exist in the model, an exception is thrown.
   * :php:`string|array|AbstractType|null $propertyValue`: The value of the property to set. This can be a string, another
     model or an array of strings or models. Also null is possible to clear the property value.

:aspect:`Return value`

   Reference to the model itself.


:php:`->setProperties(array $properties)`
-----------------------------------------

Set multiple properties at once.

:aspect:`Parameter`

   * :php:`array $properties`: The properties to set. The key of the array is the property name, the value is the
     property value. Allowed as values are the same as with the method :php:`->setProperty()`.

:aspect:`Return value`

   Reference to the model itself.


:php:`->getProperty(string $propertyName)`
------------------------------------------

Get the value of a property.

:aspect:`Parameter`

   * :php:`string $propertyName`: The property name to get the value from. If the property name does not exist in the
     model, an exception is thrown.

:aspect:`Return value`

   The value of the property (string, model, array of strings, array of models, null).


:php:`->hasProperty(string $propertyName)`
------------------------------------------

Check whether the property name exists in a particular model.

:aspect:`Parameter`

   * :php:`string $propertyName`: The property name to check.

:aspect:`Return value`

   :php:`true`, if the property exists and :php:`false`, otherwise.


:php:`->clearProperty(string $propertyName)`
--------------------------------------------

Resets the value of the property (set it to :php:`null`).

:aspect:`Parameter`

   * :php:`string $propertyName`: The property name to set. If the property does not exist in the model, an exception
     is thrown.

:aspect:`Return value`

   Reference to the model itself.


:php:`->getPropertyNames()`
---------------------------

Get the names of all properties of the model.

:aspect:`Return value`

   Array of all property names of the model.


:php:`->isEmpty()`
------------------

Checks, whether all properties of the models are empty.

:aspect:`Return value`

   :php:`true` if all properties have an empty value, :php:`false` otherwise.


Other Useful APIs
=================

.. index::
   single: Type list
   seealso: Type list; API

List of types
-------------

If you need a list of the available types or a subset of them, you can call methods on the
:php:`Brotkrueml\Schema\Provider\TypesProvider` class.

:php:`->getTypes()`
~~~~~~~~~~~~~~~~~~~

Get all available type names.

:aspect:`Return value`

   Array, sorted alphabetically by type name.

:aspect:`Example`

   .. code-block:: php

      $types = (new \Brotkrueml\Schema\Provider\TypesProvider())->getTypes();


:php:`->getWebPageTypes()`
~~~~~~~~~~~~~~~~~~~~~~~~~~

Get the `WebPage <https://schema.org/WebPage>`__ type and its descendants.

:aspect:`Return value`

   Array, sorted alphabetically by type name.


:php:`->getWebPageElementTypes()`
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Get the `WebPageElement <https://schema.org/WebPageElement>`__ type and its descendants.

:aspect:`Return value`

   Array, sorted alphabetically by type name.


:php:`->getContentTypes()`
~~~~~~~~~~~~~~~~~~~~~~~~~~

The types useful for an editor are returned as an array, sorted alphabetically.

The following types are filtered out:

 - ``BreadcrumbList``
 - ``WebPage`` and descendants
 - ``WebPageElement`` and descendants
 - ``WebSite``

:aspect:`Return value`

   Array, sorted alphabetically by type name.
