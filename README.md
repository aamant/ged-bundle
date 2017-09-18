GED
===

# Require

    Bootstrap ~4 (asset)
    Dropzonejs (asset)
    Font Awesome
    knplabs Gaufrette
    
# install

``` bash
composer require aamant/ged-bundle
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
$gedRepository = $manager->getRepository('AamantGedBundle:Directory');
$ged = $gedRepository->createRoot('name');

$manager->flush();
```

## Include GED in your template

```html
{{ render(controller('AamantGedBundle:Default:index', {'domain': 'ged', 'directory': ged})) }}
```