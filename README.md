#Simple Asset Manager for Laravel

[![Build Status](https://travis-ci.org/travis-ci/travis-web.svg?branch=master)](https://travis-ci.org/travis-ci/travis-web)

### Installation

1. Run `composer require sudomabider/laravel-asset-manager`
2. Add `Sudomabider\AssetManager\AssetManagerServiceProvider::class` to app config `providers` array
3. Run `php artisan vendor:publish --provider="Sudomabider\AssetManager\AssetManagerServiceProvider" --tag="config"`

### Configuration
All the assets are defined as key-value pairs in the `assets` array. The key would then be used in the view files to include the resources, _e.g._ `@css('animate')`.

The value part allows for 3 types of formats.

- simple resource url:
```
'css' => 'https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css'
```

- arrays of resource urls
```
'js' => [
    'https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/js/jquery.dataTables.min.js',
    'https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/js/dataTables.bootstrap.min.js'
]
```

- js also accepts an array of options. _Note_ in this case the whole js asset must be wrapped in an array
```
'js' => [
    ['https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js', ['data-pace-options' => '{ "ajax": false }']]
]
```
which outputs
```
<script data-pace-options='{ "ajax": false }' type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js'></script>
```

This can be used together with the 2nd format

### Example usage
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