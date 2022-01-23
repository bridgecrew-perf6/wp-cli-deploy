# WP CLI plugin "deploy"

WordPress CLI to deploy on remote.

# Installation

Via composer (recommended)

First add theses line in composer.json.

```json
{
  "type": "git",
  "url": "https://github.com/web-romandie/wp-cli-deploy.git"
}
```

Then, we can install the plugin:

```shell
composer require wr/wp-cli-deploy

# We can also fetch the "master" version. 
composer require wr/wp-cli-deploy dev-master  
```

Alternatively it can be installed globally with `wp package` 

```shell
wp package install https://github.com/web-romandie/wp-cli-rsync.git
```

# Configuration

We need to add some configuration in file `wp-cli.yml`

```yaml
@prod:
  ssh: username@host:port/path
```

# Usage

````shell
wp deploy dev
wp deploy prod
````
