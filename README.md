### Install Node and NPM using NVM

```shell
curl -o- https://raw.githubusercontent.com/creationix/nvm/v0.33.1/install.sh | bash

export NVM_DIR="$HOME/.nvm"
[ -s "$NVM_DIR/nvm.sh" ] && . "$NVM_DIR/nvm.sh"

nvm install 6.10.1 // for latest stable version nvm install stable

```

### Setup MySQL

```bash
// MySQL server install
wget https://dev.mysql.com/get/mysql-apt-config_0.8.3-1_all.deb

dpkg -i mysql-apt-config_0.8.3-1_all.deb

sudo apt-get install -f //or apt-get install mysql-server

sudo service mysql status //if not running: sudo service mysql start


```
### Install Javascript tools
```shell
//other dependencies
sudo apt-get install ruby-full

npm install -g bower

npm install -g grunt --save-dev

gem install sass

npm install -g grunt-cli --save-dev

npm install express --save
```
### Clone the repository and create a database
```shell
git clone https://github.com/Bowsse/Relational-MEAN.git

mysql --user=user --password=password 
```

```sql
CREATE DATABASE `mean_relational`;
```
### Run npm install to install dependencies and copy lib files.
```shell

npm install
```
* Wire up the database connection found in /config/env/development.json5 and/or /config/env/production.json5.

### Start
```shell

grunt //if no angular libraries run bower install
```

### If using 512mb Droplet create a swapfile
```shell
sudo fallocate -l 4G /swapfile

sudo chmod 600 /swapfile

sudo mkswap /swapfile

sudo swapon /swapfile

```
