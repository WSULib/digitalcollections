# Digital Collections

This framework is the primary display for the WSULS Digital Collections Platform. It uses the [Slim PHP framework](http://www.slimframework.com/), specifically the [Slim-Skeleton template](https://github.com/slimphp/Slim-Skeleton), written in PHP. This search and display interface communicates with Digital Collections infrastructure through our custom API: See [APIRequest class](../src/Services/APIRequest.php) for more info on this process.

## Installation

Run the following custom script to install composer and dependencies:

    ./provision.sh

## Running / Testing

To run the application in development, you can also run this command:

    composer start

Run this command to run the test suite:

    composer test

## Troubleshooting

Full composer reset:

    composer self-update
    composer diagnose
    composer update -v
    rm -rf vendor/
    composer update -v


## Top Level Routes

Top Level routes include

Home
* route: /

About
* route: /about

Contact
* route: /contact

Collections
* route: /collections

Search / Browse
* route: /search

Single Item / Record
* route: /item/{pid}

Single Item / Catch All Route
* route: /item/{pid}/[{params:.*}]