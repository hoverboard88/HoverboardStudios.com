HoverboardStudios.com
=====================

*This README.md is still in-process.*

The following repo is the code for our website. At Hoverboard, we believe in sharing our knowledge with others.

## Minimum Viable Code ##

We used SVG's, didn't load jQuery, and used CriticalCSS to make the front-end as light-weight as possible.

## Wordpress Install ##

We didn't include Wordpress core in this repo.

## Gulp.js ##

The task-runner used is Gulp.js. To setup, run `npm install` in `wp-content/themes/hoverboard/`. Once setup, run `gulp` to compile or `gulp watch` to watch files while editing.

## SCSS ##

We used the [Hoverboard SCSS Boilerplate](https://github.com/hoverboard88/scss-boilerplate) as a starting point.

## Git Hooks ##

If you are a committing code to this repo, make sure to symlink your `hooks` folder in you `.git` directory:

```
cd to/root/of/repo
rm -rf .git/hooks
ln -s hooks .git/hooks
```

Then php will be linted, CriticalCSS will be dealt with correctly and other checks will be made. See `hooks` directory for more info.
