#!/bin/bash
shopt -s extglob

composer reinstall monolog/monolog:^${MONOLOG_VERSION}
composer dump-autoload
