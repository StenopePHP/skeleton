# Stenope Skeleton

This skeleton is an opinionated starter kit for creating your static website
with [Stenope](https://stenopephp.github.io/Stenope/).

It contains [a few features](https://stenopephp.github.io/skeleton/articles/guide#what-s-inside) to get you started 
if you plan to create a content website from scratch along with the following stack:

- Symfony 6.1
- Webpack Encore
- Sass
- Lint / CS (php-cs-fixer, phpstan, eslint, …)
- Glide integration for images resizing
- and more…

## Create a new project

Start a new app from scratch using this skeleton with:

```shell
composer create-project stenope/skeleton -s dev
```

## Prerequisites

Either:

- Node 16+,
- PHP 8.1+
- [Symfony CLI](https://symfony.com/download)
- Composer
- Make

## Setup

Install the dependencies using

```shell
make install
```

## Dev

Start a server using

```shell
make serve
```

The Symfony CLI exposes you the URL at which the site is available.

> **Note**
> `make serve` is enough to serve both PHP app and assets.  
> You're ready to dev!

## Build

### Assets

```shell
make build.assets
```

### Content

```shell
make build.content
````

### Assets+Content

Build the whole static site from source, with assets:

```shell
make build.static
```

Serve the static version using:

```shell
make serve.static
```

## Going further

Learn more about this skeleton by browsing its content.
