#!/usr/bin/env bash
mysql -u root -ppassword test_db < "/docker-entrypoint-initdb.d/001-create-tables.sql"
