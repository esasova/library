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
- Installer le back
```bash
cd back/
```
```
composer install
```
Pour créer la base de données, il faut avoir mysql d'installé

Customisez le DATABASE_URL dans le fichier /back/.env en fonction de votre configuration

Lancer la commande de création de la base de donnée : 
```bash
php bin/console doctrine:database:create
```
Ensuite, lancer la migration : 
```bash
php bin/console doctrine:migrations:migrate
```
Créer les fixtures : 
```bash
php bin/console hautelook:fixtures:load
```
Créer les jwt key : 
```bash
php bin/console lexik:jwt:generate-keypair
```
Lancez le projet : 
```bash
symfony server:start
```

- Installer le front
```bash
cd ..
cd front
yarn install
yarn dev
## Le projet va se lancer au localhost:3000
```
User admin : 
admin@bibli.fr
psw: test

MDP pour tous les utilisateurs : test
