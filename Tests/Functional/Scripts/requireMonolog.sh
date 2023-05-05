#!/bin/bash
shopt -s extglob

cd build/testproject/
composer reinstall monolog/monolog:^${MONOLOG_VERSION}
composer dump-autoload
cd ../../
