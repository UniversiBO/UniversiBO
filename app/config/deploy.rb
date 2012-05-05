set :application, "UniversiBO"
set :domain,      "universibo.unibo.it"
set :deploy_to,   "/var/www/universibo"
set :app_path,    "app"
set :web_path,    "htmls"

set :repository,  "git@github.com:UniversiBO/UniversiBO.git"
set :scm,         :git
# Or: `accurev`, `bzr`, `cvs`, `darcs`, `subversion`, `mercurial`, `perforce`, `subversion` or `none`

set :model_manager, "doctrine"
# Or: `propel`

role :web,        domain                         # Your HTTP server, Apache/etc
role :app,        domain                         # This may be the same as your `Web` server
role :db,         domain, :primary => true       # This is where Rails migrations will run

set  :shared_files,    ["app/config/parameters.ini", "composer.lock", "config.xml", "config_cli.xml"]
set  :shared_children, [app_path + "/logs", web_path + "/img/contacts", web_path + "/forum/images/avatars","universibo/file-universibo", "universibo/log-universibo", "vendor"]

set  :update_vendors, false
set  :use_composer,   true
set  :keep_releases,  3