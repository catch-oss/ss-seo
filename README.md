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
enable_seo_cache_lifetime has been removed
for longer cache times, implement on a per project basis
See the default life time paragraph here
https://docs.silverstripe.org/en/5/developer_guides/performance/caching/#invalidation

#### Image quality
To adjust the quality of the generated images when they are resized add the following to your config/config.yml file:

GDBackend:
    default_quality: 70
    
The default Silverstripe value is 75.

### TODO

