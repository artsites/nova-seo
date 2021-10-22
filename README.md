# Art-Sites/Seo-Field

### Installation
```sh
composer require artsites/seo-field
```

### Publish
```sh
php artisan vendor:publish --provider="Artsites\SeoField\FieldServiceProvider" --tag="migration"

php artisan vendor:publish --provider="Artsites\SeoField\FieldServiceProvider" --tag="model"

php artisan vendor:publish --provider="Artsites\SeoField\FieldServiceProvider" --tag="nova-resource"
```

### Resource 

```sh
use # Artsites\SeoField\SeoField;
// in your resource 
SeoField::make()
```

#### Methods
```sh
/* Enter your route name
 * route must have parameter slug 
->routeName(string)

/* Enter default value
->defaultValue(string)
```
