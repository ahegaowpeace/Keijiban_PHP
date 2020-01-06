#!/usr/bin/env bash
mysql -u root -ppassword keijiban_db < "/docker-entrypoint-initdb.d/001-create-tables.sql"
