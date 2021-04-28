This directory contains dedicated files and configuration settings for the DiSSCo Modelling Framework Setup that are not part of the docker configuration.

Copy the image in the logos and icons in the docker volume "mediawiki-images-data". 

You can either copy and paste the content of LocalSettings_extra.php into the LocalSettings.php in the docker volume "mediawiki-config-data", after the initial installation or copy the file in the volume as well and link to it in LocalSettings.php:
```require_once "LocalSettings_extra.php";``` 