# My Blog

This application will store and manage posts.

## Installation

Clone the repository
```
git clone https://github.com/amir-nikfar/my-blog.git
```

Do a composer install
```
composer install
```

Then create a database name `my_blog`. 

## Run server

Run server using this command-
```
php artisan serve
```

Then go to `http://localhost:8000` from your browser and see the app.

## Approach

In fact, My Blog is a CRUD project using Laravel/PHP.

1. Setup a new `Laravel` project using `bootstrap`
2. Post views created. `app` view created as a default template to re-use.
3. `Post` model and database migration file created.
4. 'posts' table contains user_id, post_image, title, body and timestamps.
5. Resource route have been used for this approach.
6. `PostController` as an application controller to hanlde all endpoint methods.
7. `RatingController` to post and control user ratings.
8. Validation has been used in PostController `update` and `store` methods.
9. `Toastr` used to display action notifications.
