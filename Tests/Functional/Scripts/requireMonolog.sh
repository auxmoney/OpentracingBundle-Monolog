#!/bin/bash
shopt -s extglob

composer require monolog/monolog:^${MONOLOG_VERSION} --with-all-dependencies
composer dump-autoload
