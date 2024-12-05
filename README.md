# Chirper

A simple social media platform built with Laravel 11.

## Purpose

This is just for the sake of learning Laravel 11 basics. Initially the project starts as a follow along with the [Laravel Bootcamp](https://bootcamp.laravel.com/) - livewire part.

From that point I'll start adding my own features.

## Notes about the framework so far

-   The follow along with the Laravel Bootcamp is a good starting point, but it's definitely including a lot of magic. There's no explanation of what's happening under the hood, which I personally like to understand.
-   The reverse relationship for a chirp is not working right away. Indeed it's added in the code later - but I wanted to have the page working first, so I fixed it myself.
-   The Symfony mailer is not working out of the box with mailpit - here's [an issue with the updated version and scheme](https://github.com/laravel/framework/issues/53721).
-   General observations:
    -   Livewire is extremely cool and makes the frontend feel a lot more dynamic.
    -   The `php artisan` CLI seems quite powerful and the make commands are very useful to generate the basic files for a new feature.
    -   It looks like there's a lot less boilerplate and configuration than in Drupal (no service registration, no yamls, etc.).
    -   But on the other hand I wonder how that will look on the bigger project - all the classes are placed in the app subdirectiories - not split into modules... that might get cluttered quite fast.
    -   more to come...

## ToDo

-   [ ] Chirp comments
-   [ ] Chirp likes
-   [ ] Following users
-   [ ] User avatars
-   [ ] Slack notifications
-   [ ] Admin dashboard
-   [ ] Edit / delete chrips for admins
