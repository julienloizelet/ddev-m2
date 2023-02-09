# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en)
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [2.6.0](https://github.com/julienloizelet/ddev-m2/releases/tag/v2.6.0) - 2023-02-09
[_Compare with previous release_](https://github.com/julienloizelet/ddev-m2/compare/v2.5.0...v2.6.0)

### Changed
- Change DDEV compatibility by using `1.21.4` ddev version

### Added
- Add `redis-commander` docker-compose file
---

## [2.5.0](https://github.com/julienloizelet/ddev-m2/releases/tag/v2.5.0) - 2022-09-16
[_Compare with previous release_](https://github.com/julienloizelet/ddev-m2/compare/v2.4.1...v2.5.0)

### Changed
- Use custom nginx configuration file to handle MFTF tests

### Added
- Add `selenium` docker-compose file for `MFTF`
- Add `MFTF` default settings files
---

## [2.4.1](https://github.com/julienloizelet/ddev-m2/releases/tag/v2.4.1) - 2022-09-08
[_Compare with previous release_](https://github.com/julienloizelet/ddev-m2/compare/v2.4.0...v2.4.1)

### Fixed
- Fix `portainer` docker-compose file
---
## [2.4.0](https://github.com/julienloizelet/ddev-m2/releases/tag/v2.4.0) - 2022-08-25
[_Compare with previous release_](https://github.com/julienloizelet/ddev-m2/compare/v2.3.0...v2.4.0)

### Added
- Add `DDEV_EXPECTED_VERSION.txt` file with post-hook to compare current and expected DDEV version

### Changed
- Change `crowdsec` service to use https and TLS authentication
---
## [2.3.0](https://github.com/julienloizelet/ddev-m2/releases/tag/v2.3.0) - 2022-08-18
[_Compare with previous release_](https://github.com/julienloizelet/ddev-m2/compare/v2.2.0...v2.3.0)
### Added
- Add `portainer` service
- Add `2.3.1`, `2.3.2`, `2.3.4`, `2.3.6`, `2.3.7`, `2.4.1` and `2.4.5` configs

### Changed
- Change DDEV compatibility by using `1.21.1` ddev version

---
## [2.2.0](https://github.com/julienloizelet/ddev-m2/releases/tag/v2.2.0) - 2022-07-05
[_Compare with previous release_](https://github.com/julienloizelet/ddev-m2/compare/v2.1.0...v2.2.0)
### Added
- Add `playwright` service independent of `crowdsec` service

### Changed
- Change DDEV compatibility by using `1.19.3` ddev version

---
## [2.1.0](https://github.com/julienloizelet/ddev-m2/releases/tag/v2.1.0) - 2022-04-14
[_Compare with previous release_](https://github.com/julienloizelet/ddev-m2/compare/v2.0.0...v2.1.0)
### Added
- Add `2.4.4` config

### Changed
- Build web container with memcached 3.2.0 for PHP 8.1 compatibility

---
## [2.0.0](https://github.com/julienloizelet/ddev-m2/releases/tag/v2.0.0) - 2022-03-25
[_Compare with previous release_](https://github.com/julienloizelet/ddev-m2/compare/v1.5.0...v2.0.0)
### Added
- Add `maxmind-download` web command to download MaxMind databases

### Changed
- Change DDEV compatibility by using `1.19.1` ddev version
- Change `find-ip` command for ddev 1.19.1 compatibility
- Change `crowdsec-config` command
---
## [1.5.0](https://github.com/julienloizelet/ddev-m2/releases/tag/v1.5.0) - 2022-03-22
[_Compare with previous release_](https://github.com/julienloizelet/ddev-m2/compare/v1.4.1...v1.5.0)
### Added
- Add `nginx-config` host command to reload nginx configuration with a custom configuration file
- Add `2.4.0` config
- Add `phpinfo` script

### Changed
- Use a specific DDEV version (1.18.2)
- Update `find-ip` command to handle a default value

### Removed
- Remove test for EOL Magento 2.2.x
---
## [1.4.1](https://github.com/julienloizelet/ddev-m2/releases/tag/v1.4.1) - 2021-12-31
[_Compare with previous release_](https://github.com/julienloizelet/ddev-m2/compare/v1.4.0...v1.4.1)
### Added
- Add `2.3.5` config
- Add GitHub action for Magento 2 installation test 

---
## [1.4.0](https://github.com/julienloizelet/ddev-m2/releases/tag/v1.4.0) - 2021-11-19
[_Compare with previous release_](https://github.com/julienloizelet/ddev-m2/compare/v1.3.4...v1.4.0)
### Changed
- Modify prepend script path
- Remove useless volume for bouncer key

### Fixed
- Fix the `create-watcher` command

---
## [1.3.4](https://github.com/julienloizelet/ddev-m2/releases/tag/v1.3.4) - 2021-09-24
[_Compare with previous release_](https://github.com/julienloizelet/ddev-m2/compare/v1.3.3...v1.3.4)
### Added
- Add PHP `.ini` for auto prepend file

### Changed
- Modify Varnish `default.vcl` to handle probe url
---
## [1.3.3](https://github.com/julienloizelet/ddev-m2/releases/tag/v1.3.3) - 2021-09-10
[_Compare with previous release_](https://github.com/julienloizelet/ddev-m2/compare/v1.3.2...v1.3.3)
### Changed
- Modify `crowdsec-prepend-nginx` host command
---
## [1.3.2](https://github.com/julienloizelet/ddev-m2/releases/tag/v1.3.2) - 2021-09-03
[_Compare with previous release_](https://github.com/julienloizelet/ddev-m2/compare/v1.3.1...v1.3.2)
### Added
- Add `crowdsec-prepend-nginx` host command to add or remove an auto_prepend_file directive in nginx conf 
---
## [1.3.1](https://github.com/julienloizelet/ddev-m2/releases/tag/v1.3.1) - 2021-09-02
[_Compare with previous release_](https://github.com/julienloizelet/ddev-m2/compare/v1.3.0...v1.3.1)
### Added
- Add `cronLaunch.php` script to launch specific cron job from browser (for end-to-end playwright test purpose)
---
## [1.3.0](https://github.com/julienloizelet/ddev-m2/releases/tag/v1.3.0) - 2021-08-30
[_Compare with previous release_](https://github.com/julienloizelet/ddev-m2/compare/v1.2.2...v1.3.0)
### Added
- Add `create-bouncer` and `create-watcher` commands for `crowdsec` service
- Add `crowdsec-config` command for host: it replaces the removed post-start hook below and have to be run manually

### Changed
- Remove `start` and `stop` parameter for `cron` command as it seems quite useless and overcomplicated
- Remove `get-bouncer-key` command and associated volume.
- Modify `crowdsec` post-start hook to launch host `crowdsec-config` command 
---
## [1.2.2](https://github.com/julienloizelet/ddev-m2/releases/tag/v1.2.2) - 2021-08-27
[_Compare with previous release_](https://github.com/julienloizelet/ddev-m2/compare/v1.2.1...v1.2.2)
### Changed
- Modify `cron` command to allow `stop` and `start` parameters
- Modify `crowdsec` post-start hook to handle "key already exists" error

---
## [1.2.1](https://github.com/julienloizelet/ddev-m2/releases/tag/v1.2.1) - 2021-08-26
[_Compare with previous release_](https://github.com/julienloizelet/ddev-m2/compare/v1.2.0...v1.2.1)
### Added
- Add `get-bouncer-key` crowdsec command
### Changed
- Modify Playwright and CrowdSec dependency
- Modify `find-ip` host command to retrieve host IP if necessary
---
## [1.2.0](https://github.com/julienloizelet/ddev-m2/releases/tag/v1.2.0) - 2021-08-25
[_Compare with previous release_](https://github.com/julienloizelet/ddev-m2/compare/v1.1.1...v1.2.0)
### Added
- Add `reload-vcl` and `replace-acl` varnish command
### Changed
- Modify Varnish usage and update README

---
## [1.1.1](https://github.com/julienloizelet/ddev-m2/releases/tag/v1.1.1) - 2021-08-23
[_Compare with previous release_](https://github.com/julienloizelet/ddev-m2/compare/v1.1.0...v1.1.1)
### Added
- Add `find-ip` host command
### Changed
- Update README
---
## [1.1.0](https://github.com/julienloizelet/ddev-m2/releases/tag/v1.1.0) - 2021-08-20
[_Compare with previous release_](https://github.com/julienloizelet/ddev-m2/compare/v1.0.0...v1.1.0)
### Added
- Add Playwright composer file for end-to-end tests

---
## [1.0.0](https://github.com/julienloizelet/ddev-m2/releases/tag/v1.0.0) - 2021-08-19

### Added
- Initial release
