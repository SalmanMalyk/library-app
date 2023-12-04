<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Library Application

The Library application is a mockup website designed to display a list of the latest books along with their respective authors and publishers. In this application, each book is uniquely associated with one author, highlighting the importance of individual authorship. Additionally, recognizing the complexities of the publishing industry, the application allows for each book to be linked to multiple publishing houses, reflecting the diverse avenues through which a book can reach its audience. To facilitate dynamic interaction with the book listings, the application includes a public API. This API provides users with the capabilities to create, update, and delete book entries.

#### **To Run the application you need to follow these steps:**

- Clone the project.
- Run `composer install`.
- Run `cp .env.example .env`
- Install packages by running `npm install` and `npm run dev`.
- Add your database name in `.env` file and run `php artisan optimize:clear`.
- Run `php artisan migrate --seed`.
- That's it :)
