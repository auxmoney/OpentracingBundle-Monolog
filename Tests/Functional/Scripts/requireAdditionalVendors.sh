#!/bin/bash
shopt -s extglob

cd build/testproject/
composer require auxmoney/opentracing-bundle-monolog
rm -fr vendor/auxmoney/opentracing-bundle-monolog/*
cp -r ../../!(build|vendor) vendor/auxmoney/opentracing-bundle-monolog
composer dump-autoload
cd ../../
