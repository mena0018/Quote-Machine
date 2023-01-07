# Quote Machine - Symfony

## Sommaire

- [Installation du projet](#installation)
- [Configuration de la base de données](#configuration)
- [Lancement de l'application]("start)
- [Aperçu](#apercu)

### Installation du projet (avec Docker)

```bash
  git clone https://iut-info.univ-reims.fr/gitlab/mena0018/quote-machine.git
  cd quote-machine/
  docker-compose up -d
  docker exec -ti www_quote_machine bash
  composer install
```

### Sans docker

```bash
  git clone https://iut-info.univ-reims.fr/gitlab/mena0018/quote-machine.git
  cd quote-machine/
  composer install
```

### Configuration de la base de données

```bash
  composer db
```

### Lancement de l'application

```bash
  symfony serve
  http://127.0.0.1:8173/
```

### Aperçu

<img width="1440" alt="Screenshot 2022-11-01 at 10 45 46" src="https://user-images.githubusercontent.com/89834824/199206116-4f035345-b9fc-41e3-890f-a62c7dfe403f.png">
