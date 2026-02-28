#!/usr/bin/env bash
set -euo pipefail

composer install --prefer-dist --no-interaction --no-progress
composer test
