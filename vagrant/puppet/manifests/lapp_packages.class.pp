class lapp_packages
{
    $pgpkg = ['postgresql', 'phppgadmin']
    package { $pgpkg :
        ensure => 'latest'
    }

    $proxypkg = ['varnish']
    package { $proxypkg :
        ensure => 'latest'
    }

    package { 'rabbitmq-server' :
        ensure => 'latest'
    }

    package { 'curl' :
        ensure => 'latest'
    }

    $javapkg = [ "openjdk-7-jre-headless" ]
    package { $javapkg: ensure => "latest" }

    include php::composer
    include php::composer::auto_update
}
