
# Laravel DTO Tools

This package provides a set of tools to facilitate the creation and handling of Data Transfer Objects (DTOs) in Laravel applications. It offers attributes and interfaces that help in transforming, validating, and mapping data efficiently.

## Table of Contents

- [Installation](#installation)
- [Usage](#usage)
    - [Creating DTO Classes](#creating-dto-classes)
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
    - [Using Attributes in DTOs](#using-attributes-in-dtos)

- [Testing](#testing)
- [Code Formatting](#code-formatting)
- [Code Analysing](#code-analysing)
- [Contributing](#contributing)

## Installation

Install the package via Composer:

```bash
composer require hedgehoglab-engineering/laravel-dto
```

## Usage

### Creating DTO Classes

To create a DTO, extend the `AbstractDeclaredData` class and define your properties. You can use PHP 8 attributes to specify transformations or mappings.

```php
use HedgehoglabEngineering\LaravelDto\AbstractDeclaredData;

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

Implementing the `ResolvableData` interface allows the DTO to resolve its own properties using the specified attributes.

```php
use HedgehoglabEngineering\LaravelDto\Contracts\ResolvableData;

class UserData extends AbstractDeclaredData implements ResolvableData
{
    // ...
}
```

#### LenientData

The `LenientData` interface makes the DTO lenient by ignoring extra properties that are not defined in the class.

```php
use HedgehoglabEngineering\LaravelDto\Contracts\LenientData;

class UserData extends AbstractDeclaredData implements LenientData
{
    // ...
}
```

#### SparseData

The `SparseData` interface allows the DTO to be instantiated without all required properties. Missing properties remain unset or `null`.

```php
use HedgehoglabEngineering\LaravelDto\Contracts\SparseData;

class UserData extends AbstractDeclaredData implements SparseData
{
    // ...
}
```

### Traits

#### FromValidatedData

The `FromValidatedData` trait provides a `fromValidatedData` method to create an instance of the DTO from validated input data.

```php
use HedgehoglabEngineering\LaravelDto\Traits\FromValidatedData;

class UserData extends AbstractDeclaredData
{
    use FromValidatedData;

    // ...
}
```

### Attributes

#### CollectionOf

Transforms an array into a `Collection` of specified DTOs.

```php
use HedgehoglabEngineering\LaravelDto\Attributes\CollectionOf;

#[CollectionOf(class: PostData::class)]
public readonly Collection $posts;
```

#### DateTimeFromFormat

Parses a date string into a `DateTime` object using a specified format and timezones.

```php
use HedgehoglabEngineering\LaravelDto\Attributes\DateTimeFromFormat;

#[DateTimeFromFormat('Y-m-d', 'UTC', 'America/New_York')]
public readonly DateTimeInterface $publishedAt;
```

#### JsonDecode

Decodes a JSON string into a PHP array or object.

```php
use HedgehoglabEngineering\LaravelDto\Attributes\JsonDecode;

#[JsonDecode(associative: true)]
public readonly array $settings;
```

#### MapArgumentName

Maps an input field name to a different property name in the DTO.

```php
use HedgehoglabEngineering\LaravelDto\Attributes\MapArgumentName;

#[MapArgumentName(name: 'first_name')]
public string $firstName;
```

#### HashedIdOf

Decodes a hashed ID into the original ID using the specified model class. See [Hash Model Ids](https://github.com/netsells/hash-model-ids) for more info.

```php
use HedgehoglabEngineering\LaravelDto\Attributes\HashedIdOf;

#[HashedIdOf(User::class)]
public readonly int $userId;
```

## Examples

### Using Attributes in DTOs

Here's an example of a DTO class using various attributes:

```php
use HedgehoglabEngineering\LaravelDto\AbstractDeclaredData;
use HedgehoglabEngineering\LaravelDto\Contracts\ResolvableData;
use HedgehoglabEngineering\LaravelDto\Attributes\CollectionOf;
use HedgehoglabEngineering\LaravelDto\Attributes\DateTimeFromFormat;
use HedgehoglabEngineering\LaravelDto\Attributes\JsonDecode;
use HedgehoglabEngineering\LaravelDto\Attributes\MapArgumentName;
use HedgehoglabEngineering\LaravelDto\Attributes\HashedIdOf;
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
