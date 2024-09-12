FROM nginx:latest
COPY . .

ENTRYPOINT ["./entrypoint.sh"]
CMD ["nginx","-g","daemon off;"]