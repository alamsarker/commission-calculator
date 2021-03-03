FPM=commission-task-fpm

.PHONY : start fpm phpunit stop script

start:
	docker-compose down
	docker-compose up

fpm:
	docker exec -it $(FPM) bash

composer-install:
	docker exec -it $(FPM) bash -c 'composer install'

phpunit:
	docker exec -it $(FPM) bash -c 'bin/phpunit'

script:
	docker exec -it $(FPM) bash -c 'php script.php input.csv'
stop:
	docker-compose down
