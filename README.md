# local
```diff
docker-compose -f deploy/docker-compose.yml --env-file ./.env up --build
```
(first time)
```diff
sudo chown -R :81 storage/app
sudo chmod -R 775 storage/app
```
```diff
docker exec -t laravelapp php artisan migrate
```
```diff
docker exec -t laravelapp php artisan db:seed
```
running on http://localhost/

(or)
```diff
php artisan serve (for no docker)
```
```diff
php artisan migrate
```
```diff
php artisan db:seed
```
```diff
npm install
```
```diff
npm run dev
```


running on http://127.0.0.1:8000/


# prod

(to upload app to ec2)
```diff
"rsync -avz -e "ssh -i secretsanta.pem" ~/Documents/Sites/secret-santa/ ec2-user@3.22.116.172:~/secret-santa"
```
(to run)
```diff
sudo docker-compose -f deploy/docker-compose.yml --env-file ./.production.env up --build
```
running on http://ec2-3-22-116-172.us-east-2.compute.amazonaws.com/
