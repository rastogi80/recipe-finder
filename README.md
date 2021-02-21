# Recipe Finder

## Requirements

- PHP 7.0+
- PHPUnit 7.0+

## Usage

```
php recipe-finder.php <fridge csv file> <recipes json file>
```

### Example run

##### No Input

```
php recipe-finder.php
Valid input required.

Usage:
php /root/recipe-finder/recipe-finder.php <fridge csv> <recipes json>

Fridge.csv must be in the following format:
item, amount, unit, use-by
```

##### Invalid File

```
php recipe-finder.php invalid file
Valid input required.

Usage:
php /root/recipe-finder/recipe-finder.php <fridge csv> <recipes json>

Fridge.csv must be in the following format:
item, amount, unit, use-by
```

##### Normal Run

```
php recipe-finder.php data/fridge.csv data/recipes.json
salad sandwich
```

## Tests

PHPUnit can be installed via Composer as it is in the project's composer.json file. For more details on how to install PHPUnit click [here](http://phpunit.de/manual/current/en/installation.html)

You can run a PHPUnit test with the following command

```
vendor/phpunit/phpunit/phpunit.php tests/<Test file>
```
