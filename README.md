# Laravel REST API Assessment

This is a simple Laravel web application providing a REST API.

## Run Locally

Clone the project

```bash
  git clone https://github.com/ammarkero/laravel-rest-api-assessment.git
```

Go to the project directory

```bash
  cd laravel-rest-api-assessment
```
Generate app key

```bash
  php artisan key:generate
```

Run database migration and seeder

```bash
  php artisan migrate:refresh --seed
```

Install dependencies

```bash
  composer install
```

Start the server

```bash
  php artisan serve
```

# List of APIs

- User:
    - [get all users](#get-list-of-users)
    - [create a new user](#create-a-new-user)
    - [get a specific user](#get-a-specific-user)
    - [update an user](#update-a-specific-user)
    - [store user's role](#create-a-new-users-role) `[many-to-many relationship]`
    - [get user's role(s)](#get-list-of-users-role) `[many-to-many relationship]`
    - [delete an user](#delete-a-specific-user)
- Authentication:
    - [user login](#user-login) (generate JWToken)
    - [user logout](#user-logout)
- External data:
    - [get data from external api call](#get-data-from-external-api-call)
    - [store data from external api call](#store-data-from-external-api-call)
- Post:
    - [store post's image](#store-posts-image) `[polymorhpic relationship:one-to-one]`
    - [get post's image](#get-posts-image) `[polymorhpic relationship:one-to-one]`

# Usage/Example

The REST API to the app is described below.

## Get list of Users

#### Request

`GET /api/v1/users`

```bash
curl \
-i \
-H 'Accept: application/json' \
http://localhost:8888/api/v1/users
```

#### Response

```json
{
    "data":[
        {
        "id":1,
        "name":"Jake Smith",
        "email":"jakesmith@email.com",
        "created_at": "2023-07-04T05:36:14.000000Z",
        "updated_at": "2023-07-04T10:24:28.000000Z"
        },
        {
        "id":2,
        "name":"Donato Padberg",
        "email":"donato.padberg@email.com",
        "created_at": "2023-07-04T05:36:14.000000Z",
        "updated_at": "2023-07-04T10:24:28.000000Z"
        }
    ]
}
```

## Create a new User

#### Request

`POST /api/v1/users`

```bash
url \
-i -X POST \
-H 'Accept: application/json' \
-H 'Content-Type:application/json' \
-d '{"name": "Xavier", "email": "hello@xavier.com","password":"12345678"}' \
http://localhost:8888/api/v1/users
```

#### Response

```json
{
    "data": {
        "id": 3,
        "name": "Xavier",
        "email": "hello@xavier.com",
        "created_at": "2023-07-04T14:39:11.000000Z",
        "updated_at": "2023-07-04T14:39:11.000000Z"
    }
}
```

## Get a specific User

#### Request

`GET /api/v1/users/:id`

```bash
curl \
-i \
-H 'Accept: application/json' \
http://localhost:8888/api/v1/users/4
```

#### Response

```json
{
	"data": {
        "id":2,
        "name":"Donato Padberg",
        "email":"donato.padberg@email.com",
        "created_at": "2023-07-04T05:36:14.000000Z",
        "updated_at": "2023-07-04T10:24:28.000000Z"
    }
}
```
    
## Update a specific User

#### Request

`PUT /api/v1/users/:id`

```bash
curl \
-i -X PUT \
-H 'Accept: application/json' \
-H 'Content-Type:application/json' \
-d '{"name": "Sara","email": "hello@sara.com","password": "abc1234567"} \
http://localhost:8888/api/v1/users/1
```

#### Response

```json
{
    "data": {
        "id": 1,
        "name": "Sara",
        "email": "hello@sara.com",
        "created_at": "2023-07-04T14:39:11.000000Z",
        "updated_at": "2023-07-04T14:39:11.000000Z"
    }
}
```
    
## Create a new User's role

#### Request

`POST /api/v1/users/:id/roles`

```bash
curl \
-i -X POST \
-H 'Accept: application/json' \
-H 'Content-Type:application/json' \
-d '{"role_id": "1"}'\
http://localhost:8888/api/v1/users/2/roles
```

#### Response

```json
{
    "data": {
        "user_id": 3,
        "role_id": 1
    }
}
```

## Get list of User's role

#### Request

`GET api/v1/users/:id/roles`

```bash
curl \
-i \
-H 'Accept: application/json' \
http://localhost:8888/api/v1/users/2/roles
```

#### Response

```json
{
    "data": {
        "1": "Admin",
        "2": "User"
    }
}
```
    
## Delete a specific User

#### Request

`DELETE /api/v1/users/:id`
```bash
curl \
-i -X DELETE \
-H 'Accept: application/json' \
-H 'Content-Type:application/json' \
http://localhost:8888/api/v1/users/1
```

#### Response

```json
// Returning response status of '204 No Content'
```
    
## User Login 
Request JWToken and  store `login_timestamp` value in `user_logs` table

#### Request

`POST /api/v1/auth/login`

```bash
curl \
-i -X POST \
-H 'Accept: application/json' \
-H 'Content-Type:application/json' \
-d '{"email": "zack@hello.com", "password": "12345678"}' \
http://localhost:8888/api/v1/auth/login
```

#### Response

```json
{
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYXBpL3YxL2F1dGgvbG9naW4iLCJpYXQiOjE2ODg0ODI2MjksImV4cCI6MTY4ODQ4NjIyOSwibmJmIjoxNjg4NDgyNjI5LCJqdGkiOiIxZUVrcURSUlVKNG9ydzRkIiwic3ViIjoiMyIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.zHSfRL89l6LUdVRoWWWKfGOJzsC6c4MuPwiPClxr4BY",
    "token_type": "bearer",
    "expires_in": 3600
}
```
    
## User Logout
store `logout_timestamp` value in `user_logs` table

#### Request

`POST /api/v1/auth/logout`

```bash
curl \ 
-i -X POST \
-H 'Accept: application/json' \
-H 'Content-Type:application/json' \
-H "Authorization: Bearer {token}" \
http://localhost:8888/api/v1/auth/logout
```

#### Response

```json
{
    "message": "Successfully logged out"
}
```

## Get data from external API call

#### Request

`GET /api/v1/external-data`

```bash
curl \
-i \
-H 'Accept: application/json' \
http://localhost:8888/api/v1/external-data
```

#### Response

```json
{
    "message": "External data retrieved successfully",
    "data": [
        {
            "userId": 1,
            "id": 1,
            "title": "delectus aut autem",
            "completed": false
        },
        {
            "userId": 1,
            "id": 2,
            "title": "quis ut nam facilis et officia qui",
            "completed": false
        },
        {
            "userId": 1,
            "id": 2,

            // ...

```

## Store data from external API call

#### Request

`POST /api/v1/external-data`

```bash
curl \
-i -X POST \
-H 'Accept: application/json' \
-H 'Content-Type: application/json' \
http://localhost:8888/api/v1/external-data
```

#### Response

```json
{
    "message": "External data stored successfully",
    "count": 20
}
```

## Store Post's image

#### Request

`POST /api/v1/posts/:id/image`

```bash
curl \
-i -X POST \
-H 'Accept: application/json' \
-H 'Content-Type: application/json' \
-d '{"image_path": "unicorn-ice-cream.jpg"}'
http://localhost:8888/api/v1/posts/1/image
```

#### Response

```json
{
    "data": {
        "id": 1,
        "title": "Tallest Mountain on Earth",
        "content": "Mount Everest is Earth's highest...",
        "image": {
            "id": 1,
            "image_path": "unicorn-ice-cream.jpg"
        }
    }
}
```

## Get Post's image

#### Request

`GET /api/v1/posts/:id/image`

```bash
curl \
-i \
-H 'Accept: application/json' \
http://localhost:8888/api/v1/posts/1/image
```

#### Response

```json
{
    "data": {
        "image_path": "unicorn-ice-cream.jpg"
    }
}
```
    
## Status Codes

Response returns the following status codes in its API:

| Status Code | Description |
| :--- | :--- |
| 200 | `OK` |
| 201 | `CREATED` |
| 400 | `BAD REQUEST` |
| 404 | `NOT FOUND` |
| 429 | `TOO MANY REQUESTS` |
| 500 | `INTERNAL SERVER ERROR` |

## Useful Resources

- Locate and import Postman Collection to test API calls via Postman.

```
root
|
|- rest_api_postman_collection.json
|
```