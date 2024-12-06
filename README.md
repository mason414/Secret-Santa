# local

docker-compose -f deploy/docker-compose.yml --env-file ./.env up --build

(first time)
sudo chown -R :81 storage/app
sudo chmod -R 775 storage/app

docker exec -t laravelapp php artisan migrate

docker exec -t laravelapp php artisan db:seed

running on http://localhost/

(or)

php artisan serve (for no docker)

php artisan migrate

php artisan db:seed

npm install

npm run dev



running on http://127.0.0.1:8000/


# prod

(to upload app to ec2)
rsync -avz -e "ssh -i secretsanta.pem" ~/Documents/Sites/secret-santa/ ec2-user@3.22.116.172:~/secret-santa

(to run)
sudo docker-compose -f deploy/docker-compose.yml --env-file ./.production.env up --build

running on http://ec2-3-22-116-172.us-east-2.compute.amazonaws.com/