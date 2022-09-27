# ExcelToJson
A simple application that takes an Excel and converts it to a json file;

## Note

> Due to php memory limits we can only parse a total of 100,000 rows

The project utilises [phpoffice/phpspreadsheet](https://github.com/PHPOffice/PhpSpreadsheet) to parse the excel file.

## Installation

Clone the project

```sh
git clone https://github.com/munenepeter/ExcelToJson.git
```

Install PhpSpreadsheet using [composer](https://getcomposer.org):

```sh
composer require phpoffice/phpspreadsheet
```

Then run your development server

```sh
php -S localhost:8088
```
Finally visit http://localhost:8088/ to see upload and get your json file


## Known Issues
 1. The json returned has an extra empty field, don't know why
 2. Can only parse the first sheet of a workbook 

 For other issues, bugs or feature suggestion feel to reach out to the dev
## License

MIT
