class xvfb
{
  package {'xvfb':
    ensure => present
  }->
  file {'/etc/init.d/Xvfb':
    ensure  => present,
    content => template('xvfb/Xvfb.erb'),
    mode    => '0755',
  }->
  service {'Xvfb':
    ensure => running,
    enable => true,
  }

  file {'/etc/profile.d/xvfb.sh':
    content => 'export DISPLAY=:99',
  }
}
