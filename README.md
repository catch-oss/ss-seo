SS SEO
=====================
- Adds `Robots` tab to the site settings.
- Adds a route that points at a controller that returns plain/text Robots text from the db
- Meta` method from `abc-silverstripe-social`
- Handles canonical urls
- Updates partial caching time 
- Reduce Silverstripe GD image quality to 70

### Usage

#### Partial View Caching
This module updates the default value for partial caching from 10 minutes to 28 days.
see https://docs.silverstripe.org/en/3/developer_guides/performance/partial_caching for more details.
The extended cache lifetime can be turned off in the projects _config.php like this:

Config::inst()->update('SiteConfig', 'enable_seo_cache_lifetime', true);

#### Image quality
To adjust the quality of the generated images when they are resized add the following to your config/config.yml file:

GDBackend:
    default_quality: 70
    
The default Silverstripe value is 75.

### TODO

