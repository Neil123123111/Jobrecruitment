#!/usr/bin/env bash
set -euo pipefail

PORT="${PORT:-8080}"

# Railway provides PORT dynamically; Apache must listen on that port.
sed -ri "s/^Listen[[:space:]]+[0-9]+$/Listen ${PORT}/" /etc/apache2/ports.conf
sed -ri "s/<VirtualHost \*:[0-9]+>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf

exec apache2-foreground
