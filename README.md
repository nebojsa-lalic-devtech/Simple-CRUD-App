# PHP
Simple CRUD App
# Let's run that Composer app:

- "git clone" project locally
- all last changes are on "develop" branch
- pull the latest version of the branches
- in 'route' folder of your project launch "command prompt", "git bash" or similar
- run 'composer update' command
- after that, this time in 'public' folder of your project launch "command prompt", "git bash" or similar
- then run your server from cmd with command: "php -S localhost:8000"
- after that you should be able to access application in your browser by typing "localhost:8000" in address bar
- "localhost:8000" will open homepage with information about our Employees
- "localhost:8000/about" page will open page with information about Company
- "localhost:8000/project" page will open page with information about Project
- if you hit non-existent URLs, you will get "404 page"
- Application implement Composer, Klein router & Smarty Template Engine
