docker ps

read id

docker rm -f $id
docker rmi boto
docker build -t boto .
docker run -p 8080:5000 boto
