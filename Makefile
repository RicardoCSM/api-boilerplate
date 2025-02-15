IMAGE_NAME=api-boilerplate
CONTAINER_NAME=api-boilerplate
APP_VERSION=latest
PATH_CODE=./

TAG=stable

build:
	docker build --progress plain -t $(IMAGE_NAME):$(APP_VERSION) .

build-no-cache:
	docker build --no-cache --progress plain -t $(IMAGE_NAME):$(APP_VERSION) .

run:
	docker run --rm -it $(IMAGE_NAME):$(APP_VERSION) sh

start:
	docker run --rm --name $(CONTAINER_NAME) -p 8088:80 --user $(id -u):$(id -g) -v $(PATH_CODE):/var/www/html --network net-db $(IMAGE_NAME):$(APP_VERSION) &

sh:
	docker exec -it $(CONTAINER_NAME) /bin/sh

destroy:
	docker rm -f $(CONTAINER_NAME)

log:
	docker logs -f --tail 100 $(CONTAINER_NAME)
