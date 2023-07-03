# php-marshaller
![tests](https://github.com/onemoreangle/php-marshaller/actions/workflows/ci.yml/badge.svg)

This is a small library to serialize and deserialize PHP data structures.

> **Warning**  
> This project is currently in very early stages of development and should be considered experimental.


## Initial features
- Support for JSON serialization and deserialization
- Optional attribute / annotation-based property naming and aliasing
- Customizable handling of empty fields
- Recursive deduction of property types and optional annotation-based target types

## Installation
For general use, install the library with composer using:
```bash
composer require onemoreangle/php-marshaller --no-dev
```

## Development
Install the library using composer with dev dependencies:
```bash
composer require onemoreangle/php-marshaller
```

## Usage
### Simple usage using default settings
To serialize and deserialize, you can use any of the available serialization providers which come with defaults to read attributes/annotations. For example, to use the `Json` serialization provider with defaults:
```php
use OneMoreAngle\Marshaller\Api\Json;

$data = new CustomClass();
$serialized = Json::marshall($data);
$deserialized = Json::unmarshall($json, CustomClass::class);
```
Other serialization providers for different formats will be added in the future.

### Customizing serialization
You can customize the serialization process by creating a `SerializerBuilder` and providing it with options. Often times you will want to use the default settings of the serialization provider and then customize them, which you can do as follows
```php
use OneMoreAngle\Marshaller\Api\Json;
...
$serializer = Json::getDefaultSerializerBuilder()->withPropertyMetadataProvider(...)->build();
$data = $serializer->marshall($object);
```


## Requirements
- PHP >= 7.4 (to use attributes PHP 8.0 or higher is required, otherwise you can install doctrine/annotations and use annotations instead) 

## Contributing
Contributions are more than welcome! Please feel free to submit a pull request

## License
The php-marshaller library is released under the MIT License. See the [LICENSE](LICENSE) file for more details.
