
Le projet est dockerisé avec 6 container : SF 7.3, Vue 3, nginx, mysql, phpmyadmin et Mailhog

**Requirements** : docker-compose 3.9

## **Lancer le projet**

`docker-compose up -d --build` 
Le premier build peut prendre quelques minutes 

## **Containers**

Interface front : http://localhost:5173/ (vue-frontend)

Back : http://localhost:8000/ (symfony-backend)

PMA : http://localhost:8081/ (phpmyadmin)

Mailer : http://localhost:8025/ (mailhog)


Une fois le build effectué pour relancer le projet `docker compose up -d`

## **Stopper le projet**
`docker-compose down`

## Commande SF 
 `php bin/console check:users:daily`

## Disclaimers
Je n'ai pas réussi à catch l'event de lexik `lexik_jwt_authentication.on_authentication_success` pour mettre le champ last_connection à jour et faire fonctionner la commande, j'ai pourtant essayé avec un EventListener et un EventSubscriber (qui lui est référencé dans le `bin/console debug:event-dispatcher` mais ne semble pas trigger. J'ai quand même laissé la logique qui aurait du s'appliquer si j'avais réussi à le catch (peut-être un problème de paramétrage j'ai pourtant suivi la doc...)
Je n'ai également pas fait de test car manque de temps et je n'ai pas réussi à mettre un environnement de test dockerisé en place.
Le mailer est paramétré.
