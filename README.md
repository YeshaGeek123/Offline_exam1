### After cloning, run these:

- **composer install**
- **npm install**
- **php artisan migrate**
- **php artisan storage:link**

### Put any keys you want for these in the env file:
- PUSHER_APP_ID
- PUSHER_APP_KEY
- PUSHER_APP_SECRET

### then run:

- **npm run production**

- **php artisan config:clear**
- **php artisan cache:clear**
- **php artisan route:clear**
- **php artisan view:clear**

### After all the above are done, run the following to start the websocket server, which need to be run at all times:

- **php artisan websockets:serve**

### Finally to run the project:

- **php artisan serve**