# php-marshaller
![tests](https://github.com/onemoreangle/php-marshaller/actions/workflows/ci.yml/badge.svg)

> **Warning**  
> This project is in very early stages of development and should be considered experimental.

This is a small library with few required dependencies to serialize and deserialize PHP data structures using optional annotation-based configuration.

## Current features
- JSON and YAML serialization and deserialization
- Optional attribute or annotation-based customization of (de)serialization
- Recursive deduction of property types and optional annotation-based target types
- Circular reference detection
- Support for both PHP 8 attributes and Doctrine annotations (PHP 7.4+)

## Planned features 
- Support for other serialization formats, XML in particular
- More robust object instantiation capabilities
- User defined custom (de)serialization logic
- Performance optimizations
- Using getters and setters for data extraction and injection (as a default)

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
$serialized = Json::marshal($data);
$deserialized = Json::unmarshal($json, CustomClass::class);
```
Other serialization providers for different formats will be added in the future.

### Customizing serialization
You can customize the serialization process by creating a `SerializerBuilder` and providing it with options. Often times you will want to use the default settings of the serialization provider and then customize them, which you can do as follows

```php
use OneMoreAngle\Marshaller\Api\Json;
...
$serializer = Json::getDefaultSerializerBuilder()->withMetaExtractor(...)->build();
$data = $serializer->marshal($object);
```

### Attributes
You can use attributes to customize the (de)serialization process. For example, you can use the `Name` attribute to map a property to a different serialized name, the `Aliases` to map alternative serialized names to the property, the `Omit` attribute to omit a property from serialization, the `OmitEmpty` attribute to omit a property if it is empty, and the `TargetType` attribute to specify the type of the property to deserialize into. Let's look at an example:
```php
use OneMoreAngle\Marshaller\Attribute\Aliases;
use OneMoreAngle\Marshaller\Attribute\Name;
use OneMoreAngle\Marshaller\Attribute\Omit;
use OneMoreAngle\Marshaller\Attribute\OmitEmpty;

class CustomClass {
    #[Name('custom_name')]
    #[Aliases(['alias1', 'alias2'])]
    #[OmitEmpty]
    public string $property;
    
    #[Omit]
    public string $property2;
}
```
When you serialize an instance of the above class as follows:

```php
use OneMoreAngle\Marshaller\Api\Json;

$data = new CustomClass();
$data->property = 'test';
$data->property2 => 'test2';
$serialized = Json::marshal($data);
echo $serialized;
```
the output will be
```json
{"custom_name":"test"}
```
When we deserialize with an aliased property in the JSON:
```php
use OneMoreAngle\Marshaller\Api\Json;

$json = '{"alias2":"hello"}';
$deserialized = Json::unmarshal($json, CustomClass::class);
print_r($deserialized);
```
We get the following output:
```
CustomClass Object
(
    [property] => hello
)
```


## Requirements
- PHP >= 8.2 (you can use either attributes (recommended) or install doctrine/annotations and use annotations instead) 

## Contributing
Contributions are more than welcome! Please feel free to submit a pull request

## License
The php-marshaller library is released under the MIT License. See the [LICENSE](LICENSE) file for more details.
