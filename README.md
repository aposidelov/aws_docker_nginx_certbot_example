## Instructions of how to set up HTTPS for EC2/AmazonLinux instance

1. Create EC2/AmazonLinux instance and save Home.pem access file to /aws folder. It will allow you access instance via console without entering password.
2. Setup "Security group" with all traffic (or 80 and 443 ports) for ::/0 and 0.0.0.0/0 sources. Otherwise the instance won't be available externally. 
3. Open ec2 instance via ssh to install docker (exact open command can be found after clicking CONNECT button in aws console).

### Set up docker

1) Зайти через терминал через .pem в качестве доступа
   `ssh -i "aws/Home.pem" ec2-user@ec2-18-197-150-132.eu-central-1.compute.amazonaws.com`

2) Устанавливаем докер
   `
   a) sudo yum update -y
   b) sudo yum install -y docker
   c) sudo service docker start
   `
3) Назначаем права ec2-user на запуск докер команд без sudo
   `
   sudo usermod -a -G docker ec2-user
   id ec2-user
   newgrp docker
   `
4) Проверяем что докер установлен
   `docker info`

5) Устанавливаем docker-compose
   
  `
  a) sudo curl -L "https://github.com/docker/compose/releases/download/1.23.2/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
  b) sudo chmod +x /usr/local/bin/docker-compose
  `

6) Проверяем что docker-compose установлен
   `docker-compose --version`

7) Генерируем rsa ключ и добавляем публичный ключ в github
  `
   a) ssh-keygen
   b) cat /home/ec2-user/.ssh/id_rsa.pub - копируем и добавляем в github
   `
8) Устанавливаем git
   `sudo yum install git`

9) Вытягиваем проект с docker-compose.yml файлом из github
   `
   git clone git@github.com:aposidelov/aws_varnish_test.git
   cd aws_varnish_test
   `

10) Запускаем докер компоуз
    `docker-compose up -d`

11) Проверяем что сайт работает на 80 порту
    `` 
   docker ps
   curl http://localhost
   echo -e "\e[31mPublic IP: \e[0m"`curl -s ipecho.net/plain;echo`
    `` 
Также IP адрес должен быть добавлен на сайте где был куплен домен, например porkbun.com:
A	dev.coh3.win	18.197.150.132	600

Для тестирования можно заблокировать часть конфиг файла nginx, которая отвечает за HTTPS так как сертификаты еще не сгенерены а сайт должен быть доступен хотя бы по HTTP чтобы certbot мог сгенерить сертификаты.

Generate certbot certificates:
`docker-compose run --rm  certbot certonly --webroot -w /var/www/certbot -d dev.coh3.win --text --agree-tos --email alex.posidelov@gmail.com --rsa-key-size 4096 --verbose --keep-until-expiring --preferred-challenges=http`

