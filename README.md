# php-marshaller
![tests](https://github.com/onemoreangle/php-marshaller/actions/workflows/ci.yml/badge.svg)

This is a small library to serialize and deserialize PHP data structures, currently in a very, very, early stage of development and not suitable for use.

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
More info will be provided here when the library has a relatively stable API.

## Requirements
- PHP >= 7.4 (to use attributes PHP 8.0 or higher is required, otherwise you can install doctrine/annotations and use annotations instead) 

## Contributing
Contributions are more than welcome! Please feel free to submit a pull request

## License
The php-marshaller library is released under the MIT License. See the [LICENSE](LICENSE) file for more details.
