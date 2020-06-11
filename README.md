# Laravel Fireworks
A simple trait that will help to fire model property wise event on your laravel model. Using laravel model events, to create hooks with changed column and data.

## Installation
You can start it from composer. Go to your terminal and run this command from your project root directory.

```php
composer require hashemi/fireworks
```
## Setup
At first, you need to use `Fireworks` trait on your model where you want register your model events.

```php
class User extends Model
{
    // Use Fireworks Trait
    // ....
    use \Hashemi\Fireworks\Fireworks;
    // ....
}
```
``Fireworks`` trait add ``boot`` method on your model and register pre-defined model event hooks that already provided by laravel. This package supports ``retrieved, creating, created, updating, updated, deleting, deleted, saving, saved`` hooks. So, you don't need to register again this hooks are on ``boot`` method.

## How to use
This package will help you figure out of every hooks in methods. Example: suppose you want to use ``creating`` hooks, just declare ``onModelCreating`` method on your model. 
```php
class User extends Model
{
    // Use Fireworks Trait
    // ....
    use \Hashemi\Fireworks\Fireworks;
    protected $fillable = [
        'name',
    ];
    // ....
    protected function onModelCreating($model) {
        $model->name = "Kuddus";
    }

    protected function onModelUpdating($model) {}

    protected function onModelSaving($model) {}
    
    protected function onModelCreated($model) {}

    protected function onModelUpdated($model) {}

    protected function onModelSaved($model) {
        $model->name = "Ali";
        $model->save();
    }
    
    protected function onModelNameSaved($model, $newValue, $oldValue)
    {
        
    }
}
```
#### onModelCreating($model)
You can use ``onModelCreating`` instead of ``static::creating``

#### onModelUpdating($model)
You can use ``onModelUpdating`` instead of ``static::updating``

#### onModelSaving($model)
You can use ``onModelSaving`` instead of ``static::saving``

#### onModelDeleting($model)
You can use ``onModelDeleting`` instead of ``static::creating``

#### onModelRetrieved($model)
You can use ``onModelRetrieved`` instead of ``static::creating``

#### onModelCreated($model)
You can use ``onModelCreated`` instead of ``static::created``

#### onModelUpdated($model)
You can use ``onModelUpdated`` instead of ``static::updated``

#### onModelSaved($model)
You can use ``onModelSaved`` instead of ``static::saved``

#### onModelDeleted($model)
You can use ``onModelDeleted`` instead of ``static::deleted``

## Convention
- Your hooks method should be `onModel*` format. Where the `*` will be replaced by the StudlyCase Hooks names. So, if your hook is `creating`, then the method name should be `onModelCreating()`.
- If you want to fire event on column change wise then your hook method should be `onModel<PropertyName><Hookname>`. Where the `PropertyName` will be replaced with your column name in StudlyCase and `Hookname` will be also same way. So if your column is `phone_number` and your hook is `updating`, then the method name should be `onModelPhoneNumberUpdating()`.

## Warning
Please use hooks proper way other way data will modified in each hook. 

## Contributing
Pull requests are welcome. For any changes, please open an issue first to discuss what you would like to change.