group { 'puppet':
  ensure => present,
}

File { owner => 0, group => 0, mode => 0644 }

file { '/etc/motd':
  content => "Welcome to UniversiBO Development Kit
         Managed by Vagrant & Puppet.\n"
}

class { 'phpenv': }
#class { 'l10n': }
class { 'lapp::packages': }
class { 'lapp::config': }
class { 'universibo': }
class { 'xvfb': }

Exec {
  path => [
    '/bin/',
    '/sbin/' ,
    '/usr/bin/',
    '/usr/sbin/',
    '/usr/local/sbin',
    '/usr/local/bin',
    '/opt/vagrant_ruby/bin'
  ]
}

package {[
  'htop',
  'iceweasel',
  'tmux',
]:
  ensure => present
}

#Class['locales']->
Class['phpenv']->
Class['lapp::packages']->
Class['lapp::config']->
Class['universibo']
