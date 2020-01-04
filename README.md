# AwesomeSystem

Ex-Awesome System helper, now rofi launcher for various development tools

## Requirements

### Ubuntu

Tested on:
```bash
DISTRIB_ID=Ubuntu
DISTRIB_RELEASE=19.04
DISTRIB_CODENAME=disco
DISTRIB_DESCRIPTION="Ubuntu 19.04"
```
### Rofi, Terminator, Docker, Lazydocker

Rofi & Terminator:
```bash
sudo apt-get install rofi terminator
```
and
* [Docker](https://docs.docker.com/install/linux/docker-ce/ubuntu/)
* [LazyDocker](https://github.com/jesseduffield/lazydocker)

Current user must be in the `docker` group:

```bash
sudo usermod -aG docker <your-user>
```

### PHP & Composer

Go [here](https://getcomposer.org/download/) or copy/paste: 

```bash
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === 'baf1608c33254d00611ac1705c1d9958c817a1a33bce370c0595974b342601bd80b92a3f46067da89e3b06bff421f182') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
sudo mv composer.phar /usr/local/bin/composer
```
### Installation

Clone this repo and execute the following commands in that directory:

```bash
composer install
composer build #will require sudo password for setting up this tool system wide
```


## How to use it?

Execute:

```bash
awesome-system
```

### Helpers

```bash
#self-explanatory category
awesome-system docker:start
awesome-system docker:stop
awesome-system docker:exec #opens a terminator window with a docker exec shell.                             
                           # When closed, window will be closed as well
awesome-system docker:lazy #opens dockerlazy
awesome-system pstorm:open #assume existing directory `/workspace`, 
                           # opens a PhpStorm instance for each sub-directory that is a git root
awesome-system web:bookmarks #google-chrome bookmarks navigator
awesome-system web:quick #google-chrome quick bookmarks ( cp quicklinks.json.dist quicklinks.json )
```

### Best use!!!

Bind a system key combination for it, eg: Command + Alt + Space -> execute `awesome-system`
