#!/bin/sh

vagrant ssh -c 'wp migratedb profile 1 --path="/srv/www/hoverboardstudios/htdocs"'
