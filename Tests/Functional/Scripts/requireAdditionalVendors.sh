#!/bin/bash

cd build/testproject/
composer config repositories.origin vcs https://github.com/${PR_ORIGIN}
composer require auxmoney/opentracing-bundle-monolog:dev-${BRANCH}
cd ../../
