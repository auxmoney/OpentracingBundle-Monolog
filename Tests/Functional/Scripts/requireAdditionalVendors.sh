#!/bin/bash

cd build/testproject/
composer require auxmoney/opentracing-bundle-monolog:dev-${BRANCH}
cd ../../
