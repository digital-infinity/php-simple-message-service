composer:
	docker run --rm --interactive --tty \
	--volume $(PWD)/service:/app \
	--user $(id -u):$(id -g) \
	composer $(COMMAND) $(ARGUMENTS)

install:
	make COMMAND=install composer

test:
	docker compose run --rm --interactive \
	--volume $(PWD)/service:/app \
	--user $(id -u):$(id -g) \
	