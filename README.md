# Art-Sites/Seo-Field

### Installation
```sh
composer require artsites/nova-seo
```

### Publish
```sh
php artisan vendor:publish --provider="Artsites\NovaSeo\FieldServiceProvider" --tag="migration"

php artisan vendor:publish --provider="Artsites\NovaSeo\FieldServiceProvider" --tag="model"

php artisan vendor:publish --provider="Artsites\NovaSeo\FieldServiceProvider" --tag="nova-resource"
```

### Resource 

```sh
use # Artsites\NovaSeo\NovaSeo;
// in your resource 
NovaSeo::make()
```

#### Methods
```sh
/* Enter your route name
 * route must have parameter slug 
->routeName(string)

/* Enter default value
->defaultValue(string)
```
