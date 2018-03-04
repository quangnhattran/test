# This is open source forum I am building and optimizing from studying materials from Laracasts.com
## Step 1: Clone the repository, install composer dependencies
`git clone git@github.com:quangvision/test.git`
`cd test && composer install`
## Step 2: Setup environment file

- Change file .env.example to .env
- Edit database credentials there to fit yours
- Generate new app key by running command
`php artisan key:generate`

## Step 3 Migrate database and seed some sample data
- Migrate database by running command
`php artisan migrate`
- Seed sample data with 30 threads along with already signed in admin named "QT"
`php artisan db:seed --class=ForumSeeder`

## Step 4 Register for external API services like Google Recaptcha to protect from spammers or Algolia with Vuejs for instant searching feature
![2018-03-05_004510](https://user-images.githubusercontent.com/12606323/36948505-7fc6b2c6-200e-11e8-96d0-6577f840412b.png)

## Final Step
Access [http://test.test/threads](http://test.test/threads) for publishing your very first own thread./.