# xguard

#Installation
Clone the project first 

``
git clone https://github.com/almokhtarbr/xguard.git
``


`` cd xguard `` to enter the folder, and then install the dependencies via ``composer install``
#Setup

Copy the `` env.example `` file and rename it as ``.env``, don't forget to modify the file.

Migrate database

``
php artisan migrate
``

Then Run seeds

``
php artisan db:seed
``
You'll get a user having ``admin@example.com`` as email  and ``admin123`` as password

#Usage
Now you just need to enter your www.site.com/login
