# php-file-watcher
Watch file or folder and execute code when something is changed inside

### Demo
You can run the following command to see how the script works

```sh
php index.php FILE_OR_FOLDER_PATH
```

### Basic usage

```php
$watcher = new \tc\fswatcher\Watcher('FILE_OR_FOLDER_PATH_TO_WATCH', function ($event) {
    // Do whatever you want when file or folder is changed.
    if ($event->isAddition()){
        // File was added and file path will be $event->file
    } else if ($event->isModification()){
        // File was modified and file path will be $event->file
    }
});
$watcher->watch();
```

### Advanced Usage

```php
$watcher = new \tc\fswatcher\Watcher('FILE_OR_FOLDER_PATH_TO_WATCH', 'callback', [
    'watchInterval' => 5,
    'cacheChanges' => true
]);
```

### Options

| Option        | Default value | Description                                                      |
|---------------|---------------|------------------------------------------------------------------|
| watchInterval | 1             | How often the file changes should be checked                     |
| cacheChanges  | true          | Gather file modifications in single check and trigger event once |
