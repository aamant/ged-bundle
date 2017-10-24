GED
===

# Require

    Bootstrap ~4 (asset)
    Dropzonejs (asset)
    Font Awesome
    knplabs Gaufrette
    
# install

``` json
    "require": {
        ...
        "knplabs/knp-gaufrette-bundle": "~0.3"
    },
```

## Register the bundle

You must register the bundle in your kernel:

``` php
<?php

// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(

        // ...

        new Knp\Bundle\GaufretteBundle\KnpGaufretteBundle(),
        new Aamant\GedBundle\AamantGedBundle()
    );

    // ...
}
```
## Configure Gaufrette

```yml
knp_gaufrette:
    adapters:
        ged_local:
            local:
                directory: "%file_directory%/ged"
                create:     true
    filesystems:
        ged:
            adapter: ged_local
```

## publish asset

```bash
php app/console assets:install
```

## Modify your layout

```html
<link rel="stylesheet" href="{{ asset('bundles/aamantged/css/dropzone.min.css') }}">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
```

```html
<script src="{{ asset('bundles/aamantged/js/dropzone.min.js') }}"></script>
<script>
    Dropzone.autoDiscover = false;
</script>
<script src="{{ asset('bundles/aamantged/js/ged.js') }}"></script>
```

## Create a root directory

```php
$manager = $this->container->get('aamant_ged.manager');
$ged = $manager->createRoot('myName', 'my title');

/**
 * Associed roles
 *
 *   
 *  ROLE_GED_ROOT_{ID}_READ 
 */

```

## Check ROLE
GED Access

```ROLE_GED_ACCESS```

For specific GED

````
ROLE_GED_ROOT_{NAME}_READ
ROLE_GED_ROOT_{NAME}_WRITE
ROLE_GED_ROOT_{ID}_READ 
ROLE_GED_ROOT_{ID}_WRITE
```` 

For all GED

````
ROLE_GED_ROOT_ALL_READ
ROLE_GED_ROOT_ALL_WRITE
````


## Include GED in your template

All authorized GED for current user

```html
{% if is_granted(['ROLE_GED_ACCESS']) %}
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuGed" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {{ 'GED'|trans }}
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuGed">
            {% for ged in ged_all_root() %}
                <a class="dropdown-item" href="{{ path('ged_index', {'directory': ged.id}) }}">{{ ged.title }}</a>
            {% endfor %}
        </div>
    </li>
{% endif %}
```

GED WIDGET

"domain" is a gaufrette filesystem and "directory" is my ged

```html
{{ render(controller('AamantGedBundle:Default:index', {'domain': 'ged', 'directory': myGed})) }}
```