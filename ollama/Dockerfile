FROM ollama/ollama

ENV model=${model:-"ollama"}
# RUN ollama run ${model}
# ollama doesn't allow custom entrypoints, it executes ollama serve by default on start
# 48113d35c2f3   api-server-ollama       "/bin/ollama serve"      22 seconds ago   Up 21 seconds   0.0.0.0:8081->8081/tcp, :::8081->8081/tcp, 11434/tcp   ollama

WORKDIR /root/.ollama
COPY . .
RUN chmod +x ./entrypoint.sh
ENTRYPOINT [ "./entrypoint.sh" ]

