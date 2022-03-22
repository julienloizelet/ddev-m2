# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).


## [1.5.0] - 2022-03-22

### Added
- Add `nginx-config` host command to reload nginx configuration with a custom configuration file
- Add `2.4.0` config
- Add `phpinfo` script

### Changed
- Use a specific DDEV version (1.18.2)
- Update `find-ip` command to handle a default value

### Removed
- Remove test for EOL Magento 2.2.x

## [1.4.1] - 2021-12-31

### Added
- Add `2.3.5` config
- Add GitHub action for Magento 2 installation test 


## [1.4.0] - 2021-11-19

### Changed
- Modify prepend script path
- Remove useless volume for bouncer key

### Fixed
- Fix the `create-watcher` command


## [1.3.4] - 2021-09-24

### Added
- Add PHP `.ini` for auto prepend file

### Changed
- Modify Varnish `default.vcl` to handle probe url

## [1.3.3] - 2021-09-10

### Changed
- Modify `crowdsec-prepend-nginx` host command

## [1.3.2] - 2021-09-03

### Added
- Add `crowdsec-prepend-nginx` host command to add or remove an auto_prepend_file directive in nginx conf 

## [1.3.1] - 2021-09-02

### Added
- Add `cronLaunch.php` script to launch specific cron job from browser (for end-to-end playwright test purpose)

## [1.3.0] - 2021-08-30

### Added
- Add `create-bouncer` and `create-watcher` commands for `crowdsec` service
- Add `crowdsec-config` command for host: it replaces the removed post-start hook below and have to be run manually

### Changed
- Remove `start` and `stop` parameter for `cron` command as it seems quite useless and overcomplicated
- Remove `get-bouncer-key` command and associated volume.
- Modify `crowdsec` post-start hook to launch host `crowdsec-config` command 

## [1.2.2] - 2021-08-27

### Changed
- Modify `cron` command to allow `stop` and `start` parameters
- Modify `crowdsec` post-start hook to handle "key already exists" error


## [1.2.1] - 2021-08-26

### Added
- Add `get-bouncer-key` crowdsec command
### Changed
- Modify Playwright and CrowdSec dependency
- Modify `find-ip` host command to retrieve host IP if necessary

## [1.2.0] - 2021-08-25

### Added
- Add `reload-vcl` and `replace-acl` varnish command
### Changed
- Modify Varnish usage and update README


## [1.1.1] - 2021-08-23

### Added
- Add `find-ip` host command
### Changed
- Update README

## [1.1.0] - 2021-08-20

### Added
- Add Playwright composer file for end-to-end tests


## [1.0.0] - 2021-08-19

### Added
- Initial release
