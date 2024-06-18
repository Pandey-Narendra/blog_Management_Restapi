# Laravel Blog API

This project is a RESTful API built with the Laravel framework, providing user authentication and blog post management functionalities. Authenticated users can create, read, update, and delete their own blog posts, with a distinction between published and unpublished posts. The API also supports management of categories, tags, and comments.

## Requirements

- PHP 8.0 or higher
- Composer
- Laravel 8.x or higher
- MySQL or any other supported database

## Installation

1. **Clone the repository**

    ```bash
    git clone https://github.com/Pandey-Narendra/blog_Management_Restapi.git
    cd laravel-blog-api
    ```

2. **Install dependencies**

    ```bash
    composer install
    ```

3. **Set up environment variables**

    Copy the `.env.example` file to `.env` and update the database and other configurations as needed.

    ```bash
    cp .env.example .env
    ```

4. **Generate application key**

    ```bash
    php artisan key:generate
    ```

5. **Run migrations**

    ```bash
    php artisan migrate
    ```

6. **Run the application**

    ```bash
    php artisan serve
    ```

## API Endpoints

### User Authentication

#### Register

- **URL**: `/api/register`
- **Method**: `POST`
- **Body**:
    ```json
    {
        "name": "John Doe",
        "email": "johndoe@example.com",
        "password": "password123",
        "password_confirmation": "password123"
    }
    ```

#### Login

- **URL**: `/api/login`
- **Method**: `POST`
- **Body**:
    ```json
    {
        "email": "johndoe@example.com",
        "password": "password123"
    }
    ```

#### Logout

- **URL**: `/api/logout`
- **Method**: `POST`
- **Headers**:
    ```json
    {
        "Authorization": "Bearer {access_token}"
    }
    ```

### Post Management

#### Create a Post

- **URL**: `/api/posts`
- **Method**: `POST`
- **Headers**:
    ```json
    {
        "Authorization": "Bearer {access_token}"
    }
    ```
- **Body**:
    ```json
    {
        "title": "First Post",
        "content": "This is the content of the first post.",
        "slug": "first-post",
        "category_id": 1,
        "published": true,
        "featured_image": "http://example.com/image.jpg",
        "tags": [1, 2]
    }
    ```

#### Get All Posts

- **URL**: `/api/posts`
- **Method**: `GET`
- **Headers**:
    ```json
    {
        "Authorization": "Bearer {access_token}"
    }
    ```

#### Get a Specific Post

- **URL**: `/api/posts/{id}`
- **Method**: `GET`
- **Headers**:
    ```json
    {
        "Authorization": "Bearer {access_token}"
    }
    ```

#### Update a Post

- **URL**: `/api/posts/{id}`
- **Method**: `PUT`
- **Headers**:
    ```json
    {
        "Authorization": "Bearer {access_token}"
    }
    ```
- **Body**:
    ```json
    {
        "title": "Updated Post",
        "content": "Updated content.",
        "slug": "updated-post",
        "category_id": 1,
        "published": true,
        "featured_image": "http://example.com/updated-image.jpg",
        "tags": [1, 3]
    }
    ```

#### Delete a Post

- **URL**: `/api/posts/{id}`
- **Method**: `DELETE`
- **Headers**:
    ```json
    {
        "Authorization": "Bearer {access_token}"
    }
    ```

### Category Management

#### Create a Category

- **URL**: `/api/categories`
- **Method**: `POST`
- **Headers**:
    ```json
    {
        "Authorization": "Bearer {access_token}"
    }
    ```
- **Body**:
    ```json
    {
        "category_name": "Technology"
    }
    ```

#### Get All Categories

- **URL**: `/api/categories`
- **Method**: `GET`

#### Get a Specific Category

- **URL**: `/api/categories/{id}`
- **Method**: `GET`

#### Update a Category

- **URL**: `/api/categories/{id}`
- **Method**: `PUT`
- **Headers**:
    ```json
    {
        "Authorization": "Bearer {access_token}"
    }
    ```
- **Body**:
    ```json
    {
        "category_name": "Updated Category"
    }
    ```

#### Delete a Category

- **URL**: `/api/categories/{id}`
- **Method**: `DELETE`
- **Headers**:
    ```json
    {
        "Authorization": "Bearer {access_token}"
    }
    ```

### Tag Management

#### Create a Tag

- **URL**: `/api/tags`
- **Method**: `POST`
- **Headers**:
    ```json
    {
        "Authorization": "Bearer {access_token}"
    }
    ```
- **Body**:
    ```json
    {
        "tag_name": "Laravel"
    }
    ```

#### Get All Tags

- **URL**: `/api/tags`
- **Method**: `GET`

#### Get a Specific Tag

- **URL**: `/api/tags/{id}`
- **Method**: `GET`

#### Update a Tag

- **URL**: `/api/tags/{id}`
- **Method**: `PUT`
- **Headers**:
    ```json
    {
        "Authorization": "Bearer {access_token}"
    }
    ```
- **Body**:
    ```json
    {
        "tag_name": "Updated Tag"
    }
    ```

#### Delete a Tag

- **URL**: `/api/tags/{id}`
- **Method**: `DELETE`
- **Headers**:
    ```json
    {
        "Authorization": "Bearer {access_token}"
    }
    ```

### Comment Management

#### Create a Comment

- **URL**: `/api/comments`
- **Method**: `POST`
- **Headers**:
    ```json
    {
        "Authorization": "Bearer {access_token}"
    }
    ```
- **Body**:
    ```json
    {
        "post_id": 1,
        "comment_content": "This is a comment."
    }
    ```

#### Get All Comments

- **URL**: `/api/comments`
- **Method**: `GET`

#### Get a Specific Comment

- **URL**: `/api/comments/{id}`
- **Method**: `GET`

#### Update a Comment

- **URL**: `/api/comments/{id}`
- **Method**: `PUT`
- **Headers**:
    ```json
    {
        "Authorization": "Bearer {access_token}"
    }
    ```
- **Body**:
    ```json
    {
        "comment_content": "Updated comment content."
    }
    ```

#### Delete a Comment

- **URL**: `/api/comments/{id}`
- **Method**: `DELETE`
- **Headers**:
    ```json
    {
        "Authorization": "Bearer {access_token}"
    }
    ```

## Database Schema

### Users

- `id`
- `name`
- `email`
- `password`
- `created_at`
- `updated_at`

### Posts

- `id`
- `title`
- `content`
- `slug`
- `user_id`
- `category_id`
- `published`
- `featured_image`
- `created_at`
- `updated_at`
- `deleted_at`

### Categories

- `id`
- `category_name`
- `created_at`
- `updated_at`

### Tags

- `id`
- `tag_name`
- `created_at`
- `updated_at`

### Comments

- `id`
- `post_id`
- `comment_content`
- `commented_by`
- `commented_at`
- `created_at`
- `updated_at`

### Post_Tag (Pivot Table)

- `id`
- `post_id`
- `tag_id`
- `created_at`
- `updated_at`

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
