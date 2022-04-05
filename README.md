# wonde-task

Thank you for viewing this project! This uses the Wonde PHP Client within the Laravel framework and Tailwind CSS to provide some styling.

# Getting started

* Clone repo/download files
* Copy the .env.example file and create .env, while a database isn't required, the Wonde API key is stored here. You'll need to add WONDE_API_KEY=YOUR_API_KEY_HERE
* Navigate to the directory within terminal and run the following commands;
    * composer install
    * php artisan serve
* Once the serve command has finished, navigate to http:127.0.0.1:8000 in your browser. This should redirect you to /lessons.
* The code for this project can be found in /app/Http/Controllers/LessonController.php

# Using the project

You will see a list of all lessons that the specified teacher is teaching within the week commencing 25th April (due to there note being a full week of data prior to this date).

By clicking on the "View Students" button, this will fetch all the students that are part of the class.
