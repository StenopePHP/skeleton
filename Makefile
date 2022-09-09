.SILENT:
.PHONY: build

include ./.make/text.mk
include ./.make/help.mk

###########
# Install #
###########

## Install dependencies
install: install.composer install.npm

install.composer:
	symfony composer install

install.npm:
	npm install

## Update dependencies
update: update.composer update.npm

update.composer:
	symfony composer update

update.npm:
	npm update

###############
# Development #
###############

## Dev - Start the whole application for development purposes (local only)
serve:
	# https://www.npmjs.com/package/concurrently
	npx concurrently "make serve.php" "make serve.assets" --names="Symfony,Webpack" --prefix=name --kill-others --kill-others-on-fail

## Dev - Start Symfony server
serve.php:
	symfony server:start --no-tls

## Dev - Start webpack dev server with HMR (Hot reload)
serve.assets:
	npx encore dev-server --mode=development

## Dev - Watch assets
watch.assets:
	npm run watch

## Clear - Clear the build dir and assets
clear.build:
	rm -rf build public/build

## Clear - Clear resized images cache
clear.images:
	rm -rf public/resized

#########
# Build #
#########

## Build - Build assets
build.assets:
	npm run build

## Build - Build static site
build.content: export APP_ENV = prod
build.content:
	rm -rf public/resized
	symfony console cache:clear
	symfony console stenope:build

## Build - Build static site without resizing images, for moar speed
build.content.without-images: export APP_ENV = prod
build.content.without-images: export GLIDE_PRE_GENERATE_CACHE = 0
build.content.without-images:
	symfony console cache:clear
	symfony console stenope:build

## Build - Build static site with assets
build.static: build.assets build.content

## Serve - Serve the static version
serve.static:
	open http://localhost:8000
	symfony php -S localhost:8000 -t build

########
# Lint #
########

## Lint - Lint
lint: lint.php-cs-fixer lint.phpstan lint.twig lint.yaml lint.eslint lint.container lint.composer

lint.composer:
	symfony composer validate --no-check-publish

lint.composer@integration:
	symfony composer validate --no-check-publish --ansi --no-interaction

lint.container:
	symfony console lint:container

lint.container@integration:
	symfony console lint:container --ansi --no-interaction

lint.php-cs-fixer:
	symfony php vendor/bin/php-cs-fixer fix

lint.php-cs-fixer@integration:
	symfony php vendor/bin/php-cs-fixer fix --dry-run --diff

lint.twig: lint.twig@integration

lint.twig@integration:
	symfony console lint:twig templates --show-deprecations --ansi --no-interaction

lint.yaml: lint.yaml@integration

lint.yaml@integration:
	symfony console lint:yaml config content --parse-tags --ansi --no-interaction

lint.phpstan: export APP_ENV = test
lint.phpstan:
	symfony console cache:clear --ansi
	symfony console cache:warmup --ansi
	symfony php vendor/bin/phpstan analyse --memory-limit=-1

lint.phpstan@integration: export APP_ENV = test
lint.phpstan@integration:
	symfony php vendor/bin/phpstan --no-progress --no-interaction analyse

lint.eslint:
	npx eslint assets/js --ext .js,.json --fix

lint.eslint@integration:
	npx eslint assets/js --ext .js,.json

########
# Test #
########

## Test - Most basic test: check the build command, without images
test: build.content.without-images
test:
	$(call message_success, Most basic tests succeeded. You can ensure a \`make build.content\` is successful for more complete tests.)
