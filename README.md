1. Run `composer require thesudoteam/laravel-asset-manager`
2. Add `Thesudoteam\AssetManager\AssetManagerServiceProvider::class` to app config
3. Run `php artisan vendor:publish --provider="Thesudoteam\AssetManager\AssetManagerServiceProvider" --tag="config"`

### Example usages
___config/asset-manager.php___
```
'assets' => [
    'animate' => [
            'css' => 'https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css'
    ],
    'tagsinput' => [
        'css' => 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css',
        'js' => 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js'
    ],
    'datatables' => [
        'css' => 'https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/css/dataTables.bootstrap.min.css',
        'js' => [
            'https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/js/jquery.dataTables.min.js',
            'https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/js/dataTables.bootstrap.min.js'
        ]
    ],
    ...
]
```

___view.blade.php___
```
@css('animate', 'tagsinput', 'datatables')

@js('tagsinput', 'datatables')
```
This will create asset inclusions in your html with the corresponding urls.

You can also call urls directly
```
@css('https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css')
```