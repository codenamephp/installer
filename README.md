# Installer

![Packagist Version](https://img.shields.io/packagist/v/codenamephp/installer)
![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/codenamephp/installer)
![Lines of code](https://img.shields.io/tokei/lines/github/codenamephp/installer)
![GitHub code size in bytes](https://img.shields.io/github/languages/code-size/codenamephp/installer)
![CI](https://github.com/codenamephp/installer/workflows/CI/badge.svg)
![Packagist Downloads](https://img.shields.io/packagist/dt/codenamephp/installer)
![GitHub](https://img.shields.io/github/license/codenamephp/installer)

Installer that uses template folders to setup projects, e.g. from a github template repository

## Installation

Easiest way is via composer. Just run `composer require codenamephp/installer` in your cli which should install the latest version for you.

## Usage

The idea is to have a start script in a subfolder. The script itself just sets up the installer and the dependencies and by that also what the installer is
actually doing. The reason to put it in its own folder is so the files are clearly separated from the rest of the files so the installer can easily remove
itself.

First require the installer package using composer so we can start using its classes.

Best practice is to create a `.installer` folder and an `install.php`. The following example will render the files in the
`.installer/templates` folder into the parent folder replacing all eisting files and replacing all variables in the templates with the variables form the array.
Once this is done the `.installer` folder is deleted.

There's also variable replacement in paths. In this example, a framed replacer is used so common folder names that also might appear as variable are not
replaced by accident (like "vendor" in this example). The default for the prefix and suffix is '__' so if a file
`.installer/templates/files/__vendor__/__componentName__.json` would exist it would end up in `files/codenamephp/some.component.json`
so you can change the final structure on the fly (e.g. have a folder structure that matches your namespace).

`.installer/install.php`:

```php
use de\codenamephp\installer\StepExecutor;
use de\codenamephp\installer\steps\CopyTemplateFolder;
use de\codenamephp\installer\steps\CreateFolders;use de\codenamephp\installer\steps\DeleteFilesAndFolders;
use de\codenamephp\installer\steps\SequentialCollection;
use de\codenamephp\installer\templateCopy\directoryHandler\CreateDirectoryWithSymfonyFilesystem;
use de\codenamephp\installer\templateCopy\fileHandler\RenderWithTwigAndDumpWithSymfonyFilesystem;
use de\codenamephp\installer\templateCopy\variableReplacer\FramedStringReplace;
use Symfony\Component\Filesystem\Filesystem;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

return call_user_func(static function() {
  require_once __DIR__ . '/../vendor/autoload.php';
  
  $filesystem = new Filesystem();
  $variableReplacer = new FramedStringReplace();
  $componentName = basename(shell_exec("git config --get remote.origin.url"), '.git');
  $variables = [
            'vendor' => 'codenamephp',
            'componentName' => $componentName,
            'namespace' => implode('\\', array_merge(['de', 'codenamephp'], explode('.', $componentName)))
          ];
          
  (new StepExecutor(
    new SequentialCollection(
      new CopyTemplateFolder(
          new \de\codenamephp\installer\templateCopy\RecursiveIterator(
              new CreateDirectoryWithSymfonyFilesystem($filesystem,$variableReplacer),
              new RenderWithTwigAndDumpWithSymfonyFilesystem($filesystem, $variableReplacer, new Environment(new FilesystemLoader('/', '/')))
          ),
          __DIR__ . '/templates',
          __DIR__ . '/..',
          $variables 
      ),
      new CreateFolders($variableReplacer, $filesystem, [__DIR__ . '/../src', __DIR__ . '/../test'], $variables),
      new DeleteFilesAndFolders($filesystem, [
        __DIR__      
      ]),
    )
  ))->run();
});
```

`.installer/templates/composer.json`:

```json
{
  "name": "{{vendor}}/{{componentName}}",
  "description": "",
  "type": "library",
  "license": "Apache-2.0",
  "require": {
    "php": "^8.0"
  },
  "require-dev": {
    "dealerdirect/phpcodesniffer-composer-installer": "^0.7",
    "phpcompatibility/php-compatibility": "^9.0",
    "squizlabs/php_codesniffer": "^3.5",
    "mikey179/vfsstream": "^1.6.8"
  },
  "autoload": {
    "psr-4": {
      "{{namespace|replace({'\\':'\\\\'})}}\\": [
        "src"
      ]
    }
  },
  "autoload-dev": {
    "psr-4": {
      "{{namespace|replace({'\\':'\\\\'})}}\\test\\": [
        "test"
      ]
    }
  }
}
```

`.installer/templates/README.md`:

```markdown
# {{componentName}}

![Packagist Version](https://img.shields.io/packagist/v/{{vendor}}/{{componentName}})
![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/{{vendor}}/{{componentName}})
![Lines of code](https://img.shields.io/tokei/lines/github/{{vendor}}/{{componentName}})
![GitHub code size in bytes](https://img.shields.io/github/languages/code-size/{{vendor}}/{{componentName}})
![CI](https://github.com/{{vendor}}/{{componentName}}/workflows/CI/badge.svg)
![Packagist Downloads](https://img.shields.io/packagist/dt/{{vendor}}/{{componentName}})
![GitHub](https://img.shields.io/github/license/{{vendor}}/{{componentName}})

## Installation

Easiest way is via composer. Just run `composer require {{vendor}}/{{componentName}}` in your cli which should install the latest version for you.

## Usage
```

This example could be part of a GitHub template repository. After the repository was created on GitHub the repo can be cloned to local and after
running `composer install && php .installer/install.php && composer update` the repo would be ready for development.

This example can be adapted to the repository needs. Since the installer itself only executes steps custom steps can be added in the repository by implementing
the `\de\codenamephp\installer\steps\iStep` interface and adding it to the installer.