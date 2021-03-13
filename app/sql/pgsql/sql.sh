echo 'CREATE DATABASE universibo' | psql -U postgres
echo 'CREATE DATABASE universibo_forum3' | psql -U postgres
echo "CREATE USER universibo WITH PASSWORD 'universibo'" | psql -U postgres
echo "GRANT ALL PRIVILEGES ON DATABASE universibo TO universibo" | psql -U postgres
echo "GRANT ALL PRIVILEGES ON DATABASE universibo_forum3 TO universibo" | psql -U postgres
cat /sql/devdb.sql | psql -U postgres universibo
cat /sql/forum-{structure,data}-postgres.sql | sed 's/OWNER TO.*/OWNER TO universibo;/' | psql -U postgres universibo_forum3

