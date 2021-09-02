# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).



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
