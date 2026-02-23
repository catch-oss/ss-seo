# SS SEO

<!-- PROJECT SHIELDS -->
[![SonarCloud](https://github.com/catch-oss/ss-seo/actions/workflows/sonar.yml/badge.svg)](https://github.com/catch-oss/ss-seo/actions/workflows/sonar.yml)
[![Test](https://github.com/catch-oss/ss-seo/actions/workflows/test.yml/badge.svg)](https://github.com/catch-oss/ss-seo/actions/workflows/test.yml)
[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=catch-design_catch-oss-ss-seo&metric=alert_status)](https://sonarcloud.io/summary/new_code?id=catch-design_catch-oss-ss-seo)
[![Bugs](https://sonarcloud.io/api/project_badges/measure?project=catch-design_catch-oss-ss-seo&metric=bugs)](https://sonarcloud.io/component_measures?id=catch-design_catch-oss-ss-seo)
[![Code Smells](https://sonarcloud.io/api/project_badges/measure?project=catch-design_catch-oss-ss-seo&metric=code_smells)](https://sonarcloud.io/component_measures?id=catch-design_catch-oss-ss-seo)
[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=catch-design_catch-oss-ss-seo&metric=coverage)](https://sonarcloud.io/component_measures?id=catch-design_catch-oss-ss-seo)
[![Duplicated Lines Density](https://sonarcloud.io/api/project_badges/measure?project=catch-design_catch-oss-ss-seo&metric=duplicated_lines_density)](https://sonarcloud.io/component_measures?id=catch-design_catch-oss-ss-seo)
[![Lines of Code](https://sonarcloud.io/api/project_badges/measure?project=catch-design_catch-oss-ss-seo&metric=ncloc)](https://sonarcloud.io/component_measures?id=catch-design_catch-oss-ss-seo)
[![Reliability Rating](https://sonarcloud.io/api/project_badges/measure?project=catch-design_catch-oss-ss-seo&metric=reliability_rating)](https://sonarcloud.io/component_measures?id=catch-design_catch-oss-ss-seo)
[![Security Rating](https://sonarcloud.io/api/project_badges/measure?project=catch-design_catch-oss-ss-seo&metric=security_rating)](https://sonarcloud.io/component_measures?id=catch-design_catch-oss-ss-seo)
[![Technical Debt](https://sonarcloud.io/api/project_badges/measure?project=catch-design_catch-oss-ss-seo&metric=sqale_index)](https://sonarcloud.io/component_measures?id=catch-design_catch-oss-ss-seo)
[![Maintainability Rating](https://sonarcloud.io/api/project_badges/measure?project=catch-design_catch-oss-ss-seo&metric=sqale_rating)](https://sonarcloud.io/component_measures?id=catch-design_catch-oss-ss-seo)
[![Vulnerabilities](https://sonarcloud.io/api/project_badges/measure?project=catch-design_catch-oss-ss-seo&metric=vulnerabilities)](https://sonarcloud.io/component_measures?id=catch-design_catch-oss-ss-seo)

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
