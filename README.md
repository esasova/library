# library
## Trello : 
https://trello.com/b/BvCE4CfE/m%C3%A9diath%C3%A8que
## Mock-ups : 
https://app.moqups.com/mZpagkWfIffJQaxHd0CdTuae8ickq6Tn/view/page/ae973f342
#### Les diagrammes de classes et de sequences se trouvent dans le dossier /doc

## Technologies utilisées : 
### Back :
- PHP 7.4
- Symfony 5.3
- API Platform 2.6
- LexikJWT 2.14
- Alice Hautelook 2.9 pour créer les fixtures
- cs-fixer pour PHP
### Front
- Nuxt 2.15
#### Dépendences
- nuxt/axios 5.13
- nuxt/auth-next 5.0
- dayjs 1.10
- vuetify 2.5

## Installer le projet
- Cloner le répository
- Installer le projet symfony
```bash
cd back/
```
```
composer install
```
Lancez le projet : 
```bash
symfony server:start
```
Pour créer la base de données, il faut installer le WAMPP/MAMPP/LAMPP
Customisez la ligne suivante du fichier /back/.env :
```
DATABASE_URL="mysql://LOGIN:root@127.0.0.1:3306/library_db?serverVersion=mariadb-10.4.18"
```
Lancer la commande de création de la base de donnée : 
```bash
symfony console doctrine:database:create
```
Ensuite, lancer la migration : 
```bash
symfony console doctrine:migrations:migrate
```
Créer les fixtures : 
```bash
symfony console hautelook:fixtures:load
```
- Lancer
```bash
cd front
yarn install
yarn dev
## Le projet va se lancer au localhost:3000
```

