## Run application
### Run application by docker
```bash
# Run application
$ docker-compose up --build --remove-orphans 
# or
$ docker-compose up 


 
```
### Run command in application 
```bash

docker exec -it otalty-be bash #name of app container
$ composer install
$ bin/console doctrine:migrations:migrat
$ php bin/console doctrine:fixtures:load #load default users

 
```
Go to http://localhost:8196/
####Can change port in docker-compose file  "9000" to any valid other port and need to change it in vue app too



#### Notes
* make enusre renamed .env.exmaple
* make sure kafka running first
* to install docker Mac or windows [link](https://www.docker.com/products/docker-desktop) for Ubuntu [link](https://docs.docker.com/engine/install/ubuntu/)

