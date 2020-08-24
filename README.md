Upgrade system

```bash
sudo apt-get update
sudo apt-get upgrade -y
```


Install htop, git, tmux, vim

```bash
sudo apt-get install -y htop git tmux vim
```


Install PHP

```bash
sudo add-apt-repository ppa:ondrej/php -y
sudo apt-get update
sudo apt-get install -y php7.3
```


Install PHP extensions

```bash
sudo apt-get install -y php7.3-mbstring php7.3-ctype php7.3-bcmath php7.3-tokenizer php7.3-json php7.3-xml php7.3-opcache php7.3-mysql
```


Configure PHP

```bash
sudo cp -f php.ini /etc/php/7.3/cli/php.ini
```


Install MySQL

```bash
sudo apt-get install -y mysql-server
```


Set '12345' password for 'root' user.

```bash
sudo mysql_secure_installtion
```


Create database

```bash
mysql> CREATE DATABASE pikabu_ru_test;
```


Configure MySQL server

```bash
sudo cp -f mysqld.cnf /etc/mysql/mysql.conf.d/mysqld.cnf
sudo /etc/init.d/mysql restart
```

