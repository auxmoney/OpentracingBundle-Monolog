#!/bin/bash
shopt -s extglob

composer require monolog/monolog:^${MONOLOG_VERSION} --update-with-dependencies
composer dump-autoload
