.PHONY: rebuild


rebuild:
	if [ -f "./src/env" ]; then \
		echo "recreating env file"; \
		rm ./src/env; \
	fi
	cp ./src/.env.example ./src/.env

	chmod +x ./src/entrypoint.sh
	chmod +x ./nginx/entrypoint.sh

	docker compose down
	docker compose up --build -d