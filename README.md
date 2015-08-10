# Kirby 2 // Subpagelist

With this field plugin for [Kirby 2](http://getkirby.com) you can display the list of subpages in the main column of the panel. Simply add the new field „subpagelist” to your blueprints.

### Please notice

With this plugin I basically wanted to level up my Kirby skills (learning by doing). It is inspired by [this topic](http://forum.getkirby.com/t/showing-only-subpages/227) by [thguenther](http://forum.getkirby.com/users/thguenther/activity). If you have any tipps or suggestions, please contact me.

## Preview


![Screenshot](screenshot.png)


## Installation

### Copy & Paste

Add (if necessary) a new `fields` folder to your `site` directory. Then copy the whole content of this repository in a new folder called `subpagelist`. Your directory structure should now look like this:

```
site/
	fields/
		subpagelist/
			assests/
			languages/
			subpagelist.php
			template.php
```

### Git Submodule

It is possible to add this plugin as a Git submodule.

```bash
$ cd your/project/root  
$ git submodule add git@github.com:flokosiol/kirby-subpagelist.git site/fields/subpagelist  
```

For more information, have a look at [Working with Git](http://getkirby.com/blog/working-with-git) in the Kirby blog.


## Usage

Now you are ready to use the new field `subpagelist` in your blueprints. For now there are two optional parameter `flip` which returns the subpages in reverse order and `limit` which adds pagination.

```
...
fields:
	mysubpagelist:
		label: My Subpagelist
		type:  subpagelist
		flip:  true
		limit: 32
...
```

### Hiding the subpages in the sidebar

To hide the subpages in the sidebar, simply add this to your blueprint (as described in the [Kirby docs](http://getkirby.com/docs/panel/blueprints/page-settings#hide-subpages)):

```
...
pages:  
	hide: true  
...
```