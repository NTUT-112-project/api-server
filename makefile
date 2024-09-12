.PHONY: rebuild-rootless
.PHONY: rebuild-root
.PHONY: reload

reload:
	sudo docker compose down
	sudo docker compose up -d

rebuild-rootless: prerequisites
	docker compose down
	docker compose up --build -d

rebuild-root:prerequisites
	sudo docker compose down
	sudo docker compose up --build -d

prerequisites:
	if [ -f "./src/env" ]; then \
		echo "recreating env file"; \
		rm ./src/env; \
	fi
	cp ./src/.env.example ./src/.env

	chmod +x ./src/entrypoint.sh
	chmod +x ./nginx/entrypoint.sh
	chmod +x ./ollama/entrypoint.sh