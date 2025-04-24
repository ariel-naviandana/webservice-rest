# REST API Documentation

## Base URL

All endpoints are based on the following base URL:

```
http://localhost:8000/api
```

---

## Users

### 1. Get All Users

**Endpoint**: `GET /users`  
**Description**: Retrieve a list of all users.  
**Response**:

```json
[
    {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "role": "user",
        "created_at": "2025-04-22T12:34:56Z",
        "updated_at": "2025-04-22T12:34:56Z"
    }
]
```

### 2. Get User By ID

**Endpoint**: `GET /users/{id}`  
**Description**: Retrieve information about a specific user.  
**Response**:

```json
{
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "role": "user",
    "created_at": "2025-04-22T12:34:56Z",
    "updated_at": "2025-04-22T12:34:56Z"
}
```

### 3. Create a User

**Endpoint**: `POST /users`  
**Description**: Create a new user.  
**Request Body**:

```json
{
    "name": "Jane Doe",
    "email": "jane@example.com",
    "password": "password123",
    "role": "admin"
}
```

**Response**:

```json
{
    "id": 2,
    "name": "Jane Doe",
    "email": "jane@example.com",
    "role": "admin",
    "created_at": "2025-04-23T08:30:00Z",
    "updated_at": "2025-04-23T08:30:00Z"
}
```

### 4. Update a User

**Endpoint**: `PUT /users/{id}`  
**Description**: Update an existing user.  
**Request Body**:

```json
{
    "name": "Jane Smith",
    "email": "jane.smith@example.com",
    "password": "newpassword123",
    "role": "critic"
}
```

**Response**:

```json
{
    "id": 2,
    "name": "Jane Smith",
    "email": "jane.smith@example.com",
    "role": "critic",
    "created_at": "2025-04-23T08:30:00Z",
    "updated_at": "2025-04-23T08:35:00Z"
}
```

### 5. Delete a User

**Endpoint**: `DELETE /users/{id}`  
**Description**: Delete a specific user.  
**Response**:  
Status code `204 No Content`.

### 6. Login

**Endpoint**: `POST /login`  
**Description**: Login as user.  
**Request Body**:

```json
{
    "email": "jane@example.com",
    "password": "password123"
}
```

**Response**:

```json
{
    "id": 2,
    "name": "Jane Doe",
    "email": "jane@example.com",
    "role": "admin",
    "created_at": "2025-04-23T08:30:00Z",
    "updated_at": "2025-04-23T08:30:00Z"
}
```

---

## Reviews

### 1. Get All Reviews

**Endpoint**: `GET /reviews`  
**Description**: Retrieve a list of all reviews.

### 2. Get Review By ID

**Endpoint**: `GET /reviews/{id}`  
**Description**: Retrieve information about a specific review.

### 3. Create a Review

**Endpoint**: `POST /reviews`  
**Description**: Create a new review.  
**Request Body**:

```json
{
    "user_id": 1,
    "film_id": 3,
    "rating": 8,
    "comment": "Great movie!",
    "is_critic": true
}
```

### 4. Update a Review

**Endpoint**: `PUT /reviews/{id}`  
**Description**: Update an existing review.

### 5. Delete a Review

**Endpoint**: `DELETE /reviews/{id}`  
**Description**: Delete a specific review.

---

## Genres

### 1. Get All Genres

**Endpoint**: `GET /genres`  
**Description**: Retrieve a list of all genres.

### 2. Get Genre By ID

**Endpoint**: `GET /genres/{id}`  
**Description**: Retrieve information about a specific genre.

### 3. Create a Genre

**Endpoint**: `POST /genres`  
**Description**: Create a new genre.  
**Request Body**:

```json
{
    "name": "Action"
}
```

### 4. Update a Genre

**Endpoint**: `PUT /genres/{id}`  
**Description**: Update an existing genre.

### 5. Delete a Genre

**Endpoint**: `DELETE /genres/{id}`  
**Description**: Delete a specific genre.

### 6. Get Films By Genre

**Endpoint**: `GET /genres/{id}/films`  
**Description**: Retrieve information about films with specific genre.

---

## Casts

### 1. Get All Casts

**Endpoint**: `GET /casts`  
**Description**: Retrieve a list of all casts.

### 2. Get Cast By ID

**Endpoint**: `GET /casts/{id}`  
**Description**: Retrieve information about a specific cast.

### 3. Create a Cast

**Endpoint**: `POST /casts`  
**Description**: Create a new cast.  
**Request Body**:

```json
{
    "name": "Leonardo DiCaprio",
    "birth_date": "1974-11-11",
    "photo_url": "https://example.com/leonardo.jpg"
}
```

### 4. Update a Cast

**Endpoint**: `PUT /casts/{id}`  
**Description**: Update an existing cast.

### 5. Delete a Cast

**Endpoint**: `DELETE /casts/{id}`  
**Description**: Delete a specific cast.

### 6. Get Films By Cast

**Endpoint**: `GET /casts/{id}/films`  
**Description**: Retrieve information about films with specific cast.

---

## Films

### 1. Get All Films

**Endpoint**: `GET /films`  
**Description**: Retrieve a list of all films.

### 2. Get Film By ID

**Endpoint**: `GET /films/{id}`  
**Description**: Retrieve information about a specific film.

### 3. Create a Film

**Endpoint**: `POST /films`  
**Description**: Create a new film.  
**Request Body**:

```json
{
    "title": "Inception",
    "synopsis": "A mind-bending thriller",
    "release_year": 2010,
    "duration": 148,
    "poster_url": "https://example.com/inception.jpg",
    "director": "Christopher Nolan"
}
```

### 4. Update a Film

**Endpoint**: `PUT /films/{id}`  
**Description**: Update an existing film.

### 5. Delete a Film

**Endpoint**: `DELETE /films/{id}`  
**Description**: Delete a specific film.
