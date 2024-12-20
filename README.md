ZnoteAAC
========
[![CodeFactor](https://www.codefactor.io/repository/github/znote/znoteaac/badge)](https://www.codefactor.io/repository/github/znote/znoteaac)
### What is Znote AAC?

Znote AAC is a full-fledged website used together with an Open Tibia(OT) server.
It aims to be super easy to install and compatible with all the popular OT distributions.
It is created in PHP with a simple custom procedural framework.

### Where do I download?

We use github to distribute our versions, stable are tagged as releases, while development is the latest commit.
* [Stable](https://github.com/Znote/ZnoteAAC/releases)
* [Development](https://github.com/Znote/ZnoteAAC/archive/master.zip)

**NOTE:** Development version supports TFS 1.3, but you can expect bugs to occur.

### Compatible OT distributions
Znote AAC primarily aims to be compatible with [Forgotten Server](https://github.com/otland/forgottenserver)
Forgotten Server is commonly known as TFS (The Forgotten Server) and Znote AAC supports these versions:
* TFS 0.2.13+ (Since initial release)
* TFS 0.3.6+ (Since Znote AAC 1.2)
* TFS 1.2+ (Since Znote AAC 1.5)

### Requirements
* PHP Version 5.6 or higher. Mostly tested on 5.6 and 7.4. Most web stacks ships with this as default these days.

### Optionals
* For email registration verification and account recovery: [PHPMailer](https://github.com/PHPMailer/PHPMailer/releases) Version 6.x, extracted and renamed to just "PHPMailer" in Znote AAC directory.
* PHP extension curl for PHPMailer, paypal and google reCaptcha services.
* PHP extension openssl for google reCaptcha services.

### Installation instructions

1: Extract the .zip file to your web directory (Example: C:\UniServ\www\ )
Without modifying config.php, enter the website and wait for mysql connection error.
This will show you the rest of the instructions as well as the mysql schema.

2: Edit config.php and:
- modify $config['ServerEngine'] with correct TFS version you are running. (TFS_02, TFS_03, TFS_10, OTHIRE).
- modify $config['page_admin_access'] with your admin account username(s).

3: Before inserting correct SQL connection details, visit the website ( http://127.0.0.1/ ), it will generate a mysql schema you should import to your OT servers database.

4: Follow the steps on the website and import the SQL schema for Znote AAC, and edit config.php with correct mysql details.

5: IF you have existing database from active OT server, enter the folder called "special" and convert the database for Znote AAC support ( http://127.0.0.1/special/ )

6: Enjoy Znote AAC. You can look around [HERE](https://otland.net/forums/website-applications.118/) for plugins and resources to Znote AAC, for instance various free templates to use.

7: Please note that you need PHP cURL enabled to make Paypal payments work.

8: You may need to change directory access rights of /engine/cache to allow writing.

### Features:
Znote AAC is very rich feature wise, here is an attempt at summarizing what we offer.

#### Server distribution compatibility:
- OTHire
- TFS 0.2
- TFS 0.3/4
- TFS 1.x
- Distributions based on these (such as OTX).

#### General
- Server wide latest death list
- Server wide latest kills list
- Server information with PvP settings, skill rates, experience stages (parses config.lua and stages.xml file)
- Spells page with vocation filters (parses spells.xml file)
- Item list showing equippable items (parses items.xml file)

#### Account & login:
- Basic account registration
- Change password and email
- reCaptcha antibot(spam) system
- Email verification & lost account interface
- Two-factor authentication support
- Hide characters from character list
- Support helpdesk (tickets)

#### Create character:
- Supports custom vocations, starting skills, available towns
- Character firstitems through provided Lua script
- Soft character deletion

#### House:
- Houses list with towns filter
- House bidding
- Direct house purchase with shop points

#### Character profile
- General information such as name, vocation, level, guild membership etc...
- Obtained achievement list
- Player comments
- Death list
- Quest progression
- Character list
- EQ shower, skills, full outfits

#### Guilds
- Configurable level and account type restrictions to create guild
- Create and disband guilds
- Invite and revoke players to guild
- Change name of guild positions
- Add nickname to guild members
- Guild forum board accessible only for guild members & admin.
- Upload guild image
- Guild description
- Invite, accept and cancel war declarations
- View ongoing guild wars

#### Item market
- Want to buy list
- Want to sell list
- Item search
- Compare item offer with other similar offers, as well as transaction history

#### Downloads
- Page with download links to client version and IP changer
- Tutorial on how to connect to server

#### Achievement system
- List of all achievements and character obtained achievements in their profile.

#### Highscores
- Vocation & skill type filters

#### Buy shop points / digital currency
- PayPal payment gateway
- PayGol (SMS) payment gateway
- PagSeguro payment gateway

#### Shop system
- Items
- Premium days
- Change character gender
- Change character name
- Outfits
- Mounts
- Custom offer types. (basic Lua knowledge required)

#### Forum
- Create custom discussion boards
- Level restriction to post
- Player outfit as avatars
- Player position
- Guildboards
- Feedback board where all threads are only visible for admins.
- Hide thread, close thread, stick thread
- Forum search

#### Cache system
- Offload SQL load and CPU usage by loading treated data from a flatfile instead of raw SQL queries.

#### Administration
- Delete character
- Ban character and/or account
- Change password of account
- Give character in-game position
- Give shop points to character
- Teleport a player or all players to home town, specific town or specific position.
- Edit level and skills of player
- View in-game bug reports and feedback on forum
- Overview of shop transactions and their status
- Moderate user submitted images to the gallery
- Create news with a feature rich text editor
- Add changelogs
- Load and update server and spells information
- Helpdesk

### TODO List:
* Check [Milestones](https://github.com/Znote/ZnoteAAC/milestones)




Aqui está um exemplo de um arquivo `README.md` com o passo a passo que você forneceu:

---

# Passo a Passo para Configuração de Nginx, PHP 8.3, MariaDB e PHPMyAdmin

Este documento descreve como configurar um servidor Nginx com PHP 8.3, MariaDB e PHPMyAdmin em um ambiente Linux (Ubuntu/Debian).

## 1. Instalar o Nginx

Primeiramente, instale o servidor web Nginx:

```bash
sudo apt update
sudo apt install nginx
```

## 2. Configurar o Nginx

Edite o arquivo de configuração do Nginx para ajustar o servidor web de acordo com suas necessidades.

```bash
sudo nano /etc/nginx/sites-available/default
```

Adicione o seguinte conteúdo de configuração:

```nginx
server {
    listen 80 default_server;
    listen [::]:80 default_server;
    root /var/www/html;

    # Adicionar index.php à lista se você estiver usando PHP
    index index.php index.html index.htm index.nginx-debian.html;

    server_name example.com www.example.com;

    # Passar scripts PHP para o servidor FastCGI
    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php7.1-fpm.sock;
        # Ou com php-fpm (ou outros sockets Unix):
        # fastcgi_pass 127.0.0.1:9000;
    }
}
```

Após editar e salvar o arquivo, reinicie o Nginx para aplicar as alterações:

```bash
sudo systemctl restart nginx.service
```

## 3. Adicionar Repositório para PHP 8.3

Adicione o repositório PPA de Ondrej para PHP:

```bash
sudo add-apt-repository ppa:ondrej/php
sudo apt update
```

## 4. Instalar PHP 8.3 e Módulos

Agora, instale o PHP 8.3 e seus módulos necessários:

```bash
sudo apt-get install -y php8.3 php8.3-bcmath php8.3-curl php8.3-dom php8.3-gd php8.3-mbstring php8.3-mysql php8.3-pdo php8.3-xml
```

## 5. Instalar MariaDB

Instale o MariaDB, que é uma alternativa ao MySQL:

```bash
sudo apt install mariadb-server
```

## 6. Instalar PHP-FPM e PHPMyAdmin

Instale o PHP-FPM (FastCGI Process Manager) e o PHPMyAdmin:

```bash
sudo apt-get install php-fpm
sudo apt-get install phpmyadmin
```

## 7. Acessar o Banco de Dados e Criar um Usuário

Acesse o MariaDB e crie um novo usuário para a aplicação:

```bash
sudo mysql -u root
```

Dentro do MySQL, execute os seguintes comandos para criar o usuário:

```sql
CREATE USER 'shirelegends'@'localhost' IDENTIFIED BY 'shirelegends';
GRANT ALL PRIVILEGES ON *.* TO 'shirelegends'@'localhost';
FLUSH PRIVILEGES;
```

## 8. Modificar o `sql_mode` no MariaDB

Edite o arquivo de configuração do MariaDB para alterar o `sql_mode`:

```bash
sudo nano /etc/mysql/my.cnf
```

Dentro do arquivo, adicione ou altere a seção `[mysqld]` para ter o `sql_mode` vazio:

```ini
[mysqld]
sql_mode=''
```

Após salvar o arquivo, reinicie o serviço MariaDB:

```bash
sudo systemctl restart mariadb
```

---

### Resumo

Este passo a passo configura um ambiente de servidor com Nginx, PHP 8.3, MariaDB e PHPMyAdmin. Após seguir essas etapas, você terá um servidor web funcional com PHP e um banco de dados MariaDB pronto para ser utilizado com o PHPMyAdmin.

Se houver problemas durante a instalação ou configuração, consulte os logs do Nginx e do MariaDB para mais detalhes de erros e soluções.

---

Esse `README.md` oferece uma explicação detalhada e clara dos passos, desde a instalação do Nginx até a configuração do MariaDB e do PHP.
