
PHP Declared Data
=================

This package provides attributes, contracts, and behaviors that simplify the creation and management of data classes in PHP applications.

In particular, it enables the use of sparse objects that can be hydrated from optional data submitted via PATCH requests in a RESTful API, allowing missing or nullable fields to be handled appropriately.


## Table of Contents

- [Installation](#installation)
- [Usage](#usage)
    - [Defining Data Classes](#defining-data-classes)
    - [Interfaces](#interfaces)
        - [ResolvableData](#resolvabledata)
        - [LenientData](#lenientdata)
        - [SparseData](#sparsedata)
    - [Traits](#traits)
        - [ArraysData](#arraysdata)
        - [CollectsData](#collectsdata)
        - [CreatesData](#createsdata)
        - [DeclaresData](#declaresdata)
    - [Attributes](#attributes)
        - [CollectionOf](#collectionof)
        - [DateTimeFromFormat](#datetimefromformat)
        - [JsonDecode](#jsondecode)
        - [MapArgumentName](#mapargumentname)
- [Examples](#examples)
    - [Using Attributes in Data Classes](#using-attributes-in-data-classes)

- [Testing](#testing)
- [Code Formatting](#code-formatting)
- [Code Analysing](#code-analysing)
- [Contributing](#contributing)


## Installation

Install the package via Composer:

```bash
composer require hedgehoglab-engineering/php-declared-data
```


## Usage


### Defining Data Classes

The easiest way to start to define a declared data object is to extend the `AbstractDeclaredData` class. Alternatively, you can compose your own using the provided contracts and traits. Then just define your properties in the constructor.

```php
use HedgehoglabEngineering\DeclaredData\AbstractDeclaredData;

class UserData extends AbstractDeclaredData
{
    public function __construct(
        public string $name,
        public string $email,
        public int $age,
    ) {
        //
    }
}
```


### Interfaces

Interfaces define behaviors that can be implemented by data classes for different functionality.


#### ResolvableData

Implementing the `ResolvableData` interface allows a class to resolve its properties using the specified property type or a PHP 8 attribute.

```php
use HedgehoglabEngineering\DeclaredData\Contracts\ResolvableData;

class UserData extends AbstractDeclaredData implements ResolvableData
{
    // ...
}
```


#### LenientData

The `LenientData` interface allows the data object to ignore extra properties that are not defined in the class.

```php
use HedgehoglabEngineering\DeclaredData\Contracts\LenientData;

class UserData extends AbstractDeclaredData implements LenientData
{
    // ...
}
```


#### SparseData

The `SparseData` interface allows the data object to be instantiated without all required properties. The primary use case for this is transforming PATCH request data where missing properties without defaults may remain unset - i.e.: indicating that the field's value is not being modified.

```php
use HedgehoglabEngineering\DeclaredData\Contracts\SparseData;

class UserData extends AbstractDeclaredData implements SparseData
{
    // ...
}
```


### Traits

Traits provide reusable functionality that can be applied to your data classes.


#### ArraysData

The `ArraysData` trait provides a `toArray` method to recursively convert a data instance into an array.


#### CollectsData

The `CollectsData` trait provides a static `collect` method which can convert an iterable value into a `Illuminate\Support\Collection` of instances of the defined class.


#### CreatesData

The `CreatesData` trait provides a static `create` method which can convert data into an instance of the defined class.


#### DeclaresData

The `DeclaresData` trait provides `has`, `missing`, `only` and `except` methods, which are useful for handling instances of declared data.


### Attributes

The use of PHP attributes provides a mechanism for hinting how properties should be resolved.


#### CollectionOf

Transforms an array into an instance of `Illuminate\Support\Collection` containing instances of the specified class.

```php
use HedgehoglabEngineering\DeclaredData\Attributes\CollectionOf;

#[CollectionOf(class: PostData::class)]
public readonly Collection $posts;
```


#### DateTimeFromFormat

Parses a date string into a `DateTime` object using a specified format and/or timezone.

```php
use HedgehoglabEngineering\DeclaredData\Attributes\DateTimeFromFormat;

#[DateTimeFromFormat(format: 'Y-m-d', timezone: 'UTC', toTimezone: 'America/New_York')]
public readonly DateTimeInterface $publishedAt;
```


#### JsonDecode

Decodes a JSON string into a PHP array or object.

```php
use HedgehoglabEngineering\DeclaredData\Attributes\JsonDecode;

#[JsonDecode(associative: true)]
public readonly array $settings;
```


#### MapArgumentName

Maps an input field name to a different property name in the data object.

```php
use HedgehoglabEngineering\DeclaredData\Attributes\MapArgumentName;

#[MapArgumentName(name: 'first_name')]
public string $firstName;
```


## Examples


### Using Attributes in Data Classes

Here's an example of a data class using various attributes:

```php
use HedgehoglabEngineering\DeclaredData\AbstractDeclaredData;
use HedgehoglabEngineering\DeclaredData\Contracts\ResolvableData;
use HedgehoglabEngineering\DeclaredData\Attributes\CollectionOf;
use HedgehoglabEngineering\DeclaredData\Attributes\DateTimeFromFormat;
use HedgehoglabEngineering\DeclaredData\Attributes\JsonDecode;
use HedgehoglabEngineering\DeclaredData\Attributes\MapArgumentName;
use Illuminate\Support\Collection;

class PostData extends AbstractDeclaredData implements ResolvableData
{
    public function __construct(
        #[MapArgumentName(name: 'post_title')]
        public string $title,

        #[DateTimeFromFormat('Y-m-d H:i:s')]
        public DateTimeInterface $createdAt,

        #[JsonDecode(associative: true)]
        public array $metadata,

        #[CollectionOf(class: CommentData::class)]
        public Collection $comments,
    ) {
        //
    }
}

$inputData = [
    'post_title' => 'Test Post',
    'createdAt' => '2023-10-01 12:00:00',
    'metadata' => '{"views": 100, "likes": 10}',
    'comments' => [
        ['content' => 'Great post!'],
    ],
];

$resolvedPostData = PostData::create($inputData);
```


## Testing

```bash
composer test
```


## Code Formatting

```bash
composer format
```


## Code Analysing

```bash
composer analyse
```


## Contributing

Contributions are welcome! Please submit a pull request or open an issue to discuss your ideas.
