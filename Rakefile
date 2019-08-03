namespace :deploy do
  desc "Runs the application as daemon"
  task :up do
    sh("docker-compose up -d")
  end

  desc "Stops the application"
  task :down do
    sh("docker-compose down")
  end

  desc "Builds the application with docker"
  task :build do
    sh("docker-compose build")
  end
end

namespace :db do
  desc "Runs bash shell inside DB"
  task :shell do
    sh("docker-compose exec db bash")
  end

  desc "Runs psql shell"
  task :psql do
    sh("docker-compose exec db psql -U postgres")
  end

  desc "Loads the schema"
  task :schema do
    sh("docker-compose exec db psql -U postgres -f /sql/createdb.sql")
    sh("docker-compose exec db psql -U postgres -f /sql/devdb.sql universibo")
  end
end

desc "launch composer"
task :composer, [:params] do |_task, args|
  sh("docker-compose exec web composer -- #{args[:params]}")
end
