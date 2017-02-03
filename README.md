# NSM Revved URL plugin for Craft CMS

## Installation

To install NSM Revved URL, follow these steps:

1. Download & unzip the file and place the `nsmrevvedurl` directory into your `craft/plugins` directory
2.  -OR- do a `git clone https://github.com/Newism/nsmrevvedurl.git` directly into your `craft/plugins` folder.  You can then update it with `git pull`
3.  -OR- install with Composer via `composer require nsm/craftcms-revved-url`
4. Install plugin in the Craft Control Panel under Settings > Plugins
5. The plugin folder should be named `nsmrevvedurl` for Craft to see it.  GitHub recently started appending `-master` (the branch name) to the name of the folder for zip file downloads.

NSM Revved URL works on Craft 2.4.x and Craft 2.5.x.

## NSM Revved URL Overview

This Twig function revs asset urls with the date modified timestamp

## Using NSM Revved URL

Its simple… just call the function and pass the asset and an optional transform

    nsm_rev_url(asset, transform)

The function calls `asset.getUrl($transform)` internally and then replaces `$asset.extension` with `$asset.dateModified.timestamp . $asset.extension`. 

Before revving:

    http://example.com/uploads/images/_572x430_crop_center-center_80/James-Ellis_elevation-render-1.jpg

After revving:

    http://example.com/uploads/images/_572x430_crop_center-center_80/James-Ellis_elevation-render-1.1485302752.jpg

Here's the method:

```php
public function revUrl(AssetFileModel $asset, $transform)
{
    return str_replace(
        $asset->getExtension(),
        $asset->dateModified->getTimestamp().'.'.$asset->getExtension(),
        $asset->getUrl($transform)
    );
}
```


Brought to you by [Leevi Graham](http://newism.com.au)
