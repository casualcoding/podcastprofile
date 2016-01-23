podcastprofile
===

Source of the website.

## Set up

1. Clone
2. `composer install`

## Front end shizzle
1. `npm install`
2. `bower install`
3. `gulp` or `gulp watch`

## Vagrant with Homestead

1. Clone `git clone https://github.com/laravel/homestead.git Homestead`
2. `bash init.sh`
3. Don't have an SSH key? `ssh-keygen -t rsa -C "you@homestead"`
4. Edit `~/.homestead/Homestead.yaml`

  ```
  folders:
      - map: /path/to/podcastprofile/
        to: /home/vagrant/podcastprofile

  sites:
      - map: podcastprofile.dev
        to: /home/vagrant/podcastprofile/public
  ```

5. Add to `/etc/hosts`: ```192.168.10.10  podcastprofile.dev```
6. `vagrant up`
7. Open `http://podcastprofile.dev`
