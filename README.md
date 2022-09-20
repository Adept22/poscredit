# OTP API

* [Запуск](#запуск)
* [Доступные методы](#доступные-методы)
	* [Отправка OTP](#отправка-OTP)
	* [Получение списка чатов телеграмма](#получение-списка-чатов-телеграмма)

## Запуск

Собираем контейнеры:
```
docker-compose build --no-cache --pull
```

Запускаем контейнер:
```
docker-compose -f docker-compose.yml -f docker-compose.prod.yml up -d
```

## Доступные методы

### Отправка OTP

`POST /api/otp`

Пример запроса:
```
curl -i \
	-X POST \
	-H 'Accept: application/json' \
	-d '{ "phone": "79995551122" }' \
	http://localhost:8080/api/otp
```
Успешный ответ:
```
HTTP/1.1 200 OK
Date: Mon, 14 Sep 2022 22:35:15 GMT
Status: 200 OK
Connection: close
Content-Type: application/json
```
```json
{
    "id": "6f30da7d-a248-496e-b51a-b2b0d5bc86e6",
    "phone": "79995551122",
    "code": "$2y$12$nvLvcmUICDhx2Cj8ciOyMev6RPFZN.QGGt0i5MHT42o9jPTD..w7a",
    "createdAt": "2022-09-17T01:00:59+00:00",
    "expiresAt": "2022-09-17T01:05:59+00:00",
    "domainEvents": []
}
```

### Проверка OTP

`PUT /api/otp/{uuid}`

Пример запроса:
```
curl -i \
	-X PUT \
	-H 'Accept: application/json' \
	-d '{ "code": "855678" }' \
	http://localhost:8080/api/otp/6f30da7d-a248-496e-b51a-b2b0d5bc86e6
```
Успешный ответ:
```
HTTP/1.1 200 OK
Date: Mon, 14 Sep 2022 22:35:52 GMT
Status: 200 OK
Connection: close
Content-Type: application/json
```
```json
{
	"success": true
}
```