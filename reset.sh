idcontainer=$(docker ps | grep restapi | cut -f 1 -d " ")
docker stop $idcontainer
docker rm $idcontainer
idimage=$(docker images | grep restapi | cut -f 11 -d " ")
docker rmi $idimage
docker build --no-cache -t restapi .
docker run -p 4000:80 -d restapi apache2-foreground

