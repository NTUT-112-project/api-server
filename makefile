.PHONY: rebuild-rootless
.PHONY: rebuild-root
.PHONY: reload-rootless
.PHONY: reload-root

reload-root:
	sudo docker compose down
	sudo docker compose up -d

rebuild-rootless: prerequisites
	docker compose down
	docker compose up --build -d

rebuild-root:prerequisites
	sudo docker compose down
	sudo docker compose up --build -d

prerequisites: modelPull certs
	if [ -f "./src/env" ]; then \
		echo "recreating env file"; \
		rm ./src/env; \
	fi
	sudo cp ./src/.env.example ./src/.env

	sudo chmod +x ./src/entrypoint.sh
	sudo chmod +x ./nginx/entrypoint.sh
	sudo chmod +x ./ollama/entrypoint.sh

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

certs:
	mkdir -p ./nginx/certs
	openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout ./nginx/certs/private.key -out ./nginx/certs/certificate.crt -subj "/C=US/ST=State/L=City/O=Organization/OU=Department/CN=example.com"
	