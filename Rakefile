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
  desc "Runs psql shell"
  task :psql do
    sh("docker-compose exec db psql -U postgres")
  end
end
