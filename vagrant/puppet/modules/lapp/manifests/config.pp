class lapp::config
{
  include postgresql::server

  class {'apache':
    default_vhost => false,
    mpm_module    => 'prefork',
    user          => 'vagrant',
    group         => 'vagrant',
  }

  apache::mod { 'rpaf': }
  apache::mod { 'rewrite': }
  class {'::apache::mod::php':
  }

  postgresql::server::db { 'universibo':
    user     => 'universibo',
    password => 'universibo'
  }

  postgresql::server::db { 'universibo_forum3':
    user     => 'universibo',
    password => 'universibo'
  }

  file { '/etc/apache2/conf.d/user':
    content => "User vagrant\nGroup vagrant"
  }

  file { '/etc/profile.d/universibo.sh':
    content => 'export UNIVERSIBO_TEMP_DIR=/tmp/universibo'
  }->
  file { '/etc/apache2/envvars':
    content => template('lapp/envvars.erb')
  }

  exec { 'ports.conf':
    command => 'sed \'/^NameVirtualHost/d\' /etc/apache2/ports.conf'
  }

  exec { 'reload':
    command => 'apache2ctl graceful',
    require => Exec['ports.conf']
  }

  apache::vhost { 'default-universibo':
    priority        => '10',
    vhost_name      => '*',
    port            => '80',
    docroot         => '/vagrant/web',
    docroot_owner   => 'vagrant',
    docroot_group   => 'vagrant',
    logroot         => '/var/log',
    override        => 'All'
  }
}
