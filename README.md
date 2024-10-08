# JSON-RPC server documentation

[![License](https://img.shields.io/github/license/yoanm/php-jsonrpc-server-doc-sdk.svg)](https://github.com/yoanm/php-jsonrpc-server-doc-sdk)
[![Code size](https://img.shields.io/github/languages/code-size/yoanm/php-jsonrpc-server-doc-sdk.svg)](https://github.com/yoanm/php-jsonrpc-server-doc-sdk)
[![Dependabot Status](https://api.dependabot.com/badges/status?host=github\&repo=yoanm/php-jsonrpc-server-doc-sdk)](https://dependabot.com)

[![Scrutinizer Build Status](https://img.shields.io/scrutinizer/build/g/yoanm/php-jsonrpc-server-doc-sdk.svg?label=Scrutinizer\&logo=scrutinizer)](https://scrutinizer-ci.com/g/yoanm/php-jsonrpc-server-doc-sdk/build-status/master)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/yoanm/php-jsonrpc-server-doc-sdk/master.svg?logo=scrutinizer)](https://scrutinizer-ci.com/g/yoanm/php-jsonrpc-server-doc-sdk/?branch=master)
[![Codacy Badge](https://app.codacy.com/project/badge/Grade/20dd4e48499342b2ad40d6ce4e17daf2)](https://app.codacy.com/gh/yoanm/php-jsonrpc-server-doc-sdk/dashboard?utm_source=gh&utm_medium=referral&utm_content=&utm_campaign=Badge_grade)

[![CI](https://github.com/yoanm/php-jsonrpc-server-doc-sdk/actions/workflows/CI.yml/badge.svg?branch=master)](https://github.com/yoanm/php-jsonrpc-server-doc-sdk/actions/workflows/CI.yml)
[![codecov](https://codecov.io/gh/yoanm/php-jsonrpc-server-doc-sdk/branch/master/graph/badge.svg?token=NHdwEBUFK5)](https://codecov.io/gh/yoanm/php-jsonrpc-server-doc-sdk)

[![Latest Stable Version](https://img.shields.io/packagist/v/yoanm/jsonrpc-server-doc-sdk.svg)](https://packagist.org/packages/yoanm/jsonrpc-server-doc-sdk)
[![Packagist PHP version](https://img.shields.io/packagist/php-v/yoanm/jsonrpc-server-doc-sdk.svg)](https://packagist.org/packages/yoanm/jsonrpc-server-doc-sdk)

Php SDK to generate (Http) JSON-RPC server documentation

See [yoanm/symfony-jsonrpc-http-server-doc](https://github.com/yoanm/symfony-jsonrpc-http-server-doc) for automatic dependency injection.

See [yoanm/jsonrpc-params-symfony-constraint-doc-sdk](https://github.com/yoanm/php-jsonrpc-params-symfony-constraint-doc-sdk) for params documentation generation.

## Availble formats

*   Raw : Built-in `json` format
*   Swagger : [yoanm/jsonrpc-http-server-swagger-doc-sdk](https://github.com/yoanm/php-jsonrpc-http-server-swagger-doc-sdk)
*   OpenApi : [yoanm/jsonrpc-http-server-openapi-doc-sdk](https://github.com/yoanm/php-jsonrpc-http-server-openapi-doc-sdk)

## How to use

### Php objects

Available documentation objects:

*   [`ServerDoc`](./src/Domain/Model/ServerDoc.php) and [`HttpServerDoc`](./src/Domain/Model/HttpServerDoc.php) for HTTP server
*   [`MethodDoc`](./src/Domain/Model/MethodDoc.php)
*   [`ErrorDoc`](./src/Domain/Model/ErrorDoc.php)
*   [`TagDoc`](./src/Domain/Model/TagDoc.php) : Allow to tag methods
*   Types :
    *   [`TypeDoc`](./src/Domain/Model/Type/TypeDoc.php) : Basic type
        *   [`BooleanDoc`](./src/Domain/Model/Type/BooleanDoc.php)
        *   [`ScalarDoc`](./src/Domain/Model/Type/ScalarDoc.php)
            *   [`StringDoc`](./src/Domain/Model/Type/StringDoc.php)
            *   [`NumberDoc`](./src/Domain/Model/Type/NumberDoc.php)
                *   [`IntegerDoc`](./src/Domain/Model/Type/IntegerDoc.php)
                *   [`FloatDoc`](./src/Domain/Model/Type/FloatDoc.php)
        *   [`CollectionDoc`](./src/Domain/Model/Type/CollectionDoc.php)
            *   [`ArrayDoc`](./src/Domain/Model/Type/ArrayDoc.php)
            *   [`ObjectDoc`](./src/Domain/Model/Type/ObjectDoc.php)

### Normalizers

Available normalizers :

*   [`TypeDocNormalizer`](./src/Infra/Normalizer/TypeDocNormalizer.php)
    ```php
    use Yoanm\JsonRpcServerDoc\Infra\Normalizer\TypeDocNormalizer;

    $typeDocNormalizer = new TypeDocNormalizer();
    ```
*   [`TagDocNormalizer`](./src/Infra/Normalizer/TagDocNormalizer.php)
    ```php
    use Yoanm\JsonRpcServerDoc\Infra\Normalizer\TagDocNormalizer;

    $tagDocNormalizer = new TagDocNormalizer();
    ```
*   [`ErrorDocNormalizer`](./src/Infra/Normalizer/ErrorDocNormalizer.php)
    ```php
    use Yoanm\JsonRpcServerDoc\Infra\Normalizer\MethodDocNormalizer;

    $errorDocNormalizer = new ErrorDocNormalizer($typeDocNormalizer);
    ```
*   [`MethodDocNormalizer`](./src/Infra/Normalizer/MethodDocNormalizer.php)
    ```php
    use Yoanm\JsonRpcServerDoc\Infra\Normalizer\MethodDocNormalizer;

    $tagDocNormalizer = new MethodDocNormalizer(
      $typeDocNormalizer,
      $errorDocNormalizer
    );
    ```
*   [`ServerDocNormalizer`](./src/Infra/Normalizer/ServerDocNormalizer.php) and [`HttpServerDocNormalizer`](./src/Infra/Normalizer/HttpServerDocNormalizer.php) for HTTP server
    ```php
    use Yoanm\JsonRpcServerDoc\Infra\Normalizer\ServerDocNormalizer;
    use Yoanm\JsonRpcServerDoc\Infra\Normalizer\HttpServerDocNormalizer;

    $normalizer = new ServerDocNormalizer(
      $methodDocNormalizer,
      $tagDocNormalizer,
      $errorDocNormalizer
    );

    $httpNormalizer = new HttpServerDocNormalizer($normalizer);
    ```

## Contributing

See [contributing note](./CONTRIBUTING.md)
