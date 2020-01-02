# php-file-watcher
Watch file or folder and execute code when something is changed inside

### Demo
You can run the following command to see how the script works

```sh
php index.php FILE_OR_FOLDER_PATH
```

### For basic usage

```php
$watcher = new \tc\fswatcher\Watcher('FILE_OR_FOLDER_PATH_TO_WATCH', function (\tc\fswatcher\Event $event) {
    // Do whatever you want when file or folder is changed.
    if ($event->isAddition()){
        // File was added and file path will be $event->file
    } else if ($event->isModification()){
        // File was modified and file path will be $event->file
    }
});
$watcher->watch();
```
