.PHONY: rebuild-rootless
.PHONY: rebuild-root
.PHONY: reload

reload-root:
	sudo docker compose down
	sudo docker compose up -d

rebuild-rootless: prerequisites
	docker compose down
	docker compose up --build -d

rebuild-root:prerequisites
	sudo docker compose down
	sudo docker compose up --build -d

prerequisites: modelPull
	if [ -f "./src/env" ]; then \
		echo "recreating env file"; \
		rm ./src/env; \
	fi
	cp ./src/.env.example ./src/.env

	chmod +x ./src/entrypoint.sh
	chmod +x ./nginx/entrypoint.sh
	chmod +x ./ollama/entrypoint.sh

modelPull:
	echo "checking ollama model prerequisites"
	if [ ! -f "/usr/local/bin/ollama" ]; then \
		echo "ollama not installed"; \
		curl -fsSL https://ollama.com/install.sh | sh; \
	fi

	if [ ! -d "./ollama/models/manifests/registry.ollama.ai/library/phi3" ]; then \
		echo "phi3 demo image not installed"; \
		ollama pull phi3; \
		cp -r /usr/share/ollama/.ollama/models ./ollama; \
	fi


	