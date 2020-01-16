# auxmoney OpentracingBundle - Monolog

This bundle adds a monolog processor to the [OpentracingBundle](https://github.com/auxmoney/OpentracingBundle-core) to automatically enrich 
log contexts with the current span context.

## Installation

### Prerequisites

This bundle is only an additional plugin and should not be installed independently. See
[its documentation](https://github.com/auxmoney/OpentracingBundle-core#installation) for more information on installing the OpentracingBundle first.

### Require dependencies

After you have installed the OpentracingBundle:

* require the dependencies:

```bash
    composer req auxmoney/opentracing-bundle-monolog:^0.3
```

### Enable the bundle

If you are using [Symfony Flex](https://github.com/symfony/flex), you are all set!

If you are not using it, you need to manually enable the bundle:

* add bundle to your application:

```php
    # Symfony 3: AppKernel.php
    $bundles[] = new Auxmoney\OpentracingBundleMonolog\OpentracingMonologBundle();
```

```php
    # Symfony 4: bundles.php
    Auxmoney\OpentracingBundleMonolog\OpentracingMonologBundle::class => ['all' => true],
```

## Configuration

No configuration is necessary, the Monolog bundle extension will automatically load the provided `Processor` by tag.

## Usage

Whenever a message is logged, the content is extended with extra information of the span context.

```
    [2020-01-10 11:38:02] php.INFO: .... {"exception":"[object] (ErrorException(code: 0) ...."} {"opentracing-context":"{\"UBER-TRACE-ID\":\"15e880402e1a194715e880402e19a3e0:15e880402e19a3e0:0:1\"}"}
```

## Development

Be sure to run

```bash
    composer run-script quality
```

every time before you push code changes. The tools run by this script are also run in the CI pipeline.
