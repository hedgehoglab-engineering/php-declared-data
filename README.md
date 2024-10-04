
# PHP Declared Data

This package provides a set of tools to facilitate the creation and handling of Data Transfer in PHP applications. It offers attributes and interfaces that help in transforming, validating, and mapping data efficiently.

## Table of Contents

- [Installation](#installation)
- [Usage](#usage)
    - [Creating Data Classes](#creating-data-classes)
    - [Interfaces](#interfaces)
        - [ResolvableData](#resolvabledata)
        - [LenientData](#lenientdata)
        - [SparseData](#sparsedata)
    - [Traits](#traits)
        - [FromValidatedData](#fromvalidateddata)
    - [Attributes](#attributes)
        - [CollectionOf](#collectionof)
        - [DateTimeFromFormat](#datetimefromformat)
        - [JsonDecode](#jsondecode)
        - [MapArgumentName](#mapargumentname)
        - [HashedIdOf](#hashedidof)
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

### Creating Data Classes

To create a data object, extend the `AbstractDeclaredData` class and define your properties. You can use PHP 8 attributes to specify transformations or mappings.

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

#### ResolvableData

Implementing the `ResolvableData` interface allows the data object to resolve its own properties using the specified attributes.

```php
use HedgehoglabEngineering\DeclaredData\Contracts\ResolvableData;

class UserData extends AbstractDeclaredData implements ResolvableData
{
    // ...
}
```

#### LenientData

The `LenientData` interface makes the data object lenient by ignoring extra properties that are not defined in the class.

```php
use HedgehoglabEngineering\DeclaredData\Contracts\LenientData;

class UserData extends AbstractDeclaredData implements LenientData
{
    // ...
}
```

#### SparseData

The `SparseData` interface allows the data object to be instantiated without all required properties. Missing properties remain unset or `null`.

```php
use HedgehoglabEngineering\DeclaredData\Contracts\SparseData;

class UserData extends AbstractDeclaredData implements SparseData
{
    // ...
}
```

### Traits

#### FromValidatedData

The `FromValidatedData` trait provides a `fromValidatedData` method to create an instance of the data from validated input data.

```php
use HedgehoglabEngineering\DeclaredData\Traits\FromValidatedData;

class UserData extends AbstractDeclaredData
{
    use FromValidatedData;

    // ...
}
```

### Attributes

#### CollectionOf

Transforms an array into a `Collection` of specified data.

```php
use HedgehoglabEngineering\DeclaredData\Attributes\CollectionOf;

#[CollectionOf(class: PostData::class)]
public readonly Collection $posts;
```

#### DateTimeFromFormat

Parses a date string into a `DateTime` object using a specified format and timezones.

```php
use HedgehoglabEngineering\DeclaredData\Attributes\DateTimeFromFormat;

#[DateTimeFromFormat('Y-m-d', 'UTC', 'America/New_York')]
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

#### HashedIdOf

Decodes a hashed ID into the original ID using the specified model class. See [Hash Model Ids](https://github.com/netsells/hash-model-ids) for more info.

```php
use HedgehoglabEngineering\DeclaredData\Attributes\HashedIdOf;

#[HashedIdOf(User::class)]
public readonly int $userId;
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
use HedgehoglabEngineering\DeclaredData\Attributes\HashedIdOf;
use Illuminate\Support\Collection;

class PostData extends AbstractDeclaredData implements ResolvableData
{
    public function __construct(
        #[MapArgumentName(name: 'post_title')]
        public string $title,

        #[DateTimeFromFormat('Y-m-d H:i:s')]
        public DateTimeInterface $createdAt,

        #[HashedIdOf(User::class)]
        public int $authorId,

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
    'authorId' => 'hashed_123',
    'metadata' => '{"views": 100, "likes": 10}',
    'comments' => [
        ['content' => 'Great post!', 'user_id' => 'hashed_456'],
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
