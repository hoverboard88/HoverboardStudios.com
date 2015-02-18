# HoverboardStudios.com #

The following repo is the code for our website. At Hoverboard, we believe in sharing our knowledge with others.

## Minimum Viable Code ##

We purposefully didn't use a CMS for this website so we could make it as light-weight as possible. We used SVG's, didn't load jQuery, and used CriticalCSS.

## Vagrant ##

Included is a virtual environment using Vagrant. Prerequisites are the following:

* [VirtualBox](https://www.virtualbox.org/wiki/Downloads)
* [Vagrant](https://www.vagrantup.com/downloads.html)
* [Vagrant Hostmanager](https://github.com/smdahlen/vagrant-hostmanager)

Run `vagrant up` on the root directory of the repo and navigate to [hoverboardstudios.vagrant](http://hoverboardstudios.vagrant) in your browser.

## Gulp.js ##

The task-runner used is Gulp.js. To setup, run `npm install` in `www/`. Once setup, run `gulp` to compile or `gulp watch` to watch files while editing.

## SCSS ##

We used the [Hoverboard SCSS Boilerplate](https://github.com/hoverboard88/scss-boilerplate) as a starting point.