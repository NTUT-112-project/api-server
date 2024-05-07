#!/bin/bash
pwd
exec ls -al

ollama pull ollama3
ollama lis

exec ollama run ollama3