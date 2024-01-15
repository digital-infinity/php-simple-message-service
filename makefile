composer:
	docker run --rm --interactive --tty \
	--volume $$(pwd)/service:/app \
	--user $$(id -u):$$(id -g) \
	composer $(COMMAND) $(ARGUMENTS)

install:
	make COMMAND=install composer

test:
	docker compose run --rm --interactive \
	message-service php ./vendor/bin/phpunit