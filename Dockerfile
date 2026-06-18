FROM php:alpine

WORKDIR /app

COPY . .

CMD [ "sleep", "infinity" ]