class selenium($version='2.45', $minor = '0')
{
  include wget

  file {'/opt/selenium/':
    ensure => directory
  }->
  wget::fetch { "http://selenium-release.storage.googleapis.com/${version}/selenium-server-standalone-${version}.${minor}.jar":
    destination => "/opt/selenium/server-standalone-${version}.${minor}.jar",
    timeout     => 0,
    verbose     => false,
  }->
  file {'/etc/init.d/selenium':
    ensure  => present,
    content => template('selenium/selenium.erb'),
    mode    => '0755',
  }->
  service {'selenium':
    ensure => running,
    enable => true,
  }
}
