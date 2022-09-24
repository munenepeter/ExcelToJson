# ExcelToJson
A simple application that takes an Excel and converts it to a json file;

## Note

> The JSON file created is in a specific format so its not for use for all excel files, to achieve that simply extend the project :)

The project utilises [phpoffice/phpspreadsheet](https://github.com/PHPOffice/PhpSpreadsheet) to parse the excel file.

## Installation

Clone the project

```sh
git clone https://github.com/munenepeter/ExcelToJson.git
```

Install PhpSpreadsheet using composer [composer](https://getcomposer.org):

```sh
composer require phpoffice/phpspreadsheet
```

Then run your development server

```sh
php -S localhost:8088
```
Finally visit http://localhost:8088/ to see the tool

## License

MIT
