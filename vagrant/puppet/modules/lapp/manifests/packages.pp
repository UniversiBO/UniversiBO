class lapp::packages
{
    $pgpkg = [
        'postgresql',
        'phppgadmin'
    ]

    package { $pgpkg :
        ensure => 'latest'
    }

    package { 'curl' :
        ensure => 'latest'
    }

    $javapkg = [ "openjdk-7-jre-headless" ]
    package { $javapkg: ensure => "latest" }
}
