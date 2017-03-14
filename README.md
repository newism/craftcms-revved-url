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

    nsm_rev_asset_url(asset, transform)

Before revving:

    http://example.com/uploads/images/_572x430_crop_center-center_80/James-Ellis_elevation-render-1.jpg

After revving:

    http://example.com/uploads/images/_572x430_crop_center-center_80/James-Ellis_elevation-render-1.1485302752.jpg

### Imager Support

NSM Revved URL supports [Imager](https://github.com/aelvan/Imager-Craft) transforms and `craft.imager.srcset()` 
by wrapping the Imager plugin functions. 

#### Returned a revved URL

    {{ nsm_rev_imager_url(newsImage, {
         mode: 'crop',
         width: 375,
         height: 282,
         quality: 75,
         position: newsImage.focusPctX ~ '% ' ~ newsImage.focusPctY ~ '%'
     }) }}
     
#### Returned a revved Imager model

Caution this replaces the original `url` property

     {% set revvedImagerAsset = nsm_rev_imager_asset(newsImage, {
          mode: 'crop',
          width: 375,
          height: 282,
          quality: 75,
          position: newsImage.focusPctX ~ '% ' ~ newsImage.focusPctY ~ '%'
      }) }}
      
      {# output the revved URL #}
      {{ revvedImagerAsset.url }}

#### Returned a revved Imager model for use with `craft.imager.srcset()`

{% set revvedImagerAsset = nsm_rev_imager_asset(newsImage, {
          mode: 'crop',
          width: 400,
          ratio: '16/9',
          position: newsImage.focusPctX ~ '% ' ~ newsImage.focusPctY ~ '%'
      }, {
           mode: 'crop',
           width: 800,
           ratio: '16/9',
           position: newsImage.focusPctX ~ '% ' ~ newsImage.focusPctY ~ '%'
       }) }}
      
      {# output the revved URL #}
      {{ craft.imager.srcset(revvedImagerAsset) }}

## Updating your server config

This plugin doesn't actually change the the filename on the server. You'll need to implement rewrite rules on your server.

#### Apache

See: https://github.com/h5bp/server-configs-apache/blob/master/dist/.htaccess#L968-L984

    # ----------------------------------------------------------------------
    # | Filename-based cache busting                                       |
    # ----------------------------------------------------------------------

    # If you're not using a build process to manage your filename version
    # revving, you might want to consider enabling the following directives
    # to route all requests such as `/style.12345.css` to `/style.css`.
    #
    # To understand why this is important and even a better solution than
    # using something like `*.css?v231`, please see:
    # http://www.stevesouders.com/blog/2008/08/23/revving-filenames-dont-use-querystring/

    # <IfModule mod_rewrite.c>
    #     RewriteEngine On
    #     RewriteCond %{REQUEST_FILENAME} !-f
    #     RewriteRule ^(.+)\.(\d+)\.(bmp|css|cur|gif|ico|jpe?g|js|png|svgz?|webp|webmanifest)$ $1.$3 [L]
    # </IfModule>
    
#### NGINX

See: https://github.com/h5bp/server-configs-nginx/blob/master/h5bp/location/cache-busting.conf#L1-L10

    # Built-in filename-based cache busting

    # This will route all requests for /css/style.20120716.css to /css/style.css
    # Read also this: github.com/h5bp/html5-boilerplate/wiki/cachebusting
    # This is not included by default, because it'd be better if you use the build
    # script to manage the file names.
    location ~* (.+)\.(?:\d+)\.(js|css|png|jpg|jpeg|gif)$ {
      try_files $uri $1.$2;
    }


[<img src="http://newism.com.au/uploads/content/newism-logo.png" width="150px" />](http://newism.com.au/)

Brought to you by [Leevi Graham](http://newism.com.au)
