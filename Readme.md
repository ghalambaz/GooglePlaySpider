## Google Play Store Spider

### Step 1 : add package with composer
`composer require ghalambaz/googleplay-spider`
### Step 2 : create instanse of GooglePlaySpider
`$spider = new GooglePlaySpider();`
### Step 3 : Package (App or Game) Name you want to receive
>in our example package name is **ir.yana.esaj**

`$package = $spider->getPackageByPackageName("ir.yana.esaj");`
### Step 4 : Get Information of Package

```php
$package->getTitle();
//return : (esaj) ایساج

$package->getFeaturedImageAddress();
//return : address of main (featured) icon image

$res = $package->getDeveloper();
//return : array with two keys [title,link]

$package->getPackageCategory();

$package->isEditorChoice();
//return : true of false that shows is Editor choice or not!

$package->getESRB();
//return : ESRB image link

$package->getScreenshots();
//return : screenshots as array with keys[height,width,link]

$package->getDescription();
//return : full description of app

$package->getWhatsNew();
//return : text about what is new in this version

$package->getRating();
//return : array with keys[rate,total] which total is how many people rate this app

$package->getAdditionalInfo();
//return : information about [Updated Date, Size, Installs, Current Version, Require Android, Content Rating,Offered By ,etc... ]

$package->getSimilar();
//return : array of 6 package information with keys[image,title,link,developer,developer_link,description]
```
