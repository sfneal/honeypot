# Changelog

All notable changes to `honeypot` will be documented in this file

## 0.1.0 - 2020-11-02
- initial release


## 0.1.1 - 2020-11-11
- fix issue with importing of SpamResponder interface


## 0.2.0 - 2020-12-11
- add support for php8
- fix import errors


## 0.3.0 - 2021-03-09
- add missing sfneal package requirements (actions, models, scopes)


## 0.4.0 - 2021-03-09
- make TrackSpamQuery for retrieving recent TrackSpam records
- add sfneal/datum composer requirement to use AbstractQuery


## 0.4.1 - 2021-03-10
- cut `getCreatedAtDateAttribute()` & `getCreatedAtTimeAttribute()` methods from TrackSpam because those methods have been added to AbstractModel in sfneal/models package
- bump min sfneal/models version to 1.2


## 0.4.2 - 2021-03-30
- fix sfneal package version constraint syntax
- add scrutinizer/ocular to dev requirements


## 0.5.0 - 2021-03-31
- bump min sfneal/actions package version to 2.0
