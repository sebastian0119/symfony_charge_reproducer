# Symfony Reproducer

## Strange behaviour of form_errors in two different forms

see also related post at [Symfony Discussions](https://github.com/symfony/symfony/discussions/58673)

This repository includes all relevant information to reproduce the error messages that are displayed at the beginning of the `charge/new` form (instead of next to each label).

You will need connection to a database that contains some basic information; migrations for MariaDB / MySQL are included.

The relevant route is `https://localhost:8000/charge/new` (with the built-in Symfony server).

