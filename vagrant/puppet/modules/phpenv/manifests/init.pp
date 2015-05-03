class phpenv
{
    include php

    class {'php::apache': } ->package{'php5-json': }
    class {'php::cli': }

    class {['php::composer', 'php::composer::auto_update']: }
    class {'php::extension::curl': }
    class {'php::extension::intl': }
    class {'php::extension::mysql': }
    class {'php::extension::pgsql': }

    package {'php-apc': }
    package{'php5-dev': } ->
    class {'php::pear': } ->
    php::cli::config {'CLI TimeZone':
        config => [
            'set Date/date.timezone Europe/Rome'
        ]
    }->
    php::apache::config {'Apache TimeZone':
        config => [
            'set Date/date.timezone Europe/Rome'
        ]
    }

    file {'/var/lib/php5':
      ensure => directory,
      owner => 'vagrant',
      group => 'vagrant',
    }
}
