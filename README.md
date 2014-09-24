wordpress-ccb-api-plugin
========================

A WordPress plugin that allows integration with the Community Church Builder (CCB) API.

## Contents

The WordPress CCB API Plugin includes the following files:

* `.gitignore`.  Used to exclude certain files from the repository.
* `ChangeLog.md`.  The list of changes to the core project.
* `README.md`.  The file that you are currently reading.
* A `ccb-api` directory that contains the source code - a fully executable WordPress plugin.

## Features

* The WordPress CCB API Plugin is based on the [WordPress-Plugin-Boilerplate](https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate) template.

## Installation

### via Add Plugins

1.  Download the plugin from GitHub using either *Download ZIP* or one of the release tags.
2.  In the WordPress dashboard, navigate to the *Plugins* -> *Add New* page.
3.  Click *Upload Plugin.*
4.  Click *Choose File* and select the download from *Step 1*.
5.  Click *Install Now.*
6.  Click on *Activate Plugin.*
7.  In the WordPress dashboard, navigate to the *Plugins* -> *CCB Plugin* page.  Configure the plugin.  The CCB API users are configured in the CCB application unders *Settings* -> *API*.
8.  Click on *Save Changes*

## Usage

The API is exposed via a series of WordPress shortcodes.

### [ccb_current_events] shortcode

This displays an upcoming calendar of events.  `[ccb_current_events days="10"]` will display a list of calendar events for the next 10 days.  `days` is optional and defaults to 7 if not specified.

## Important Notes

### Licensing

The WordPress CCB API Plugin is licensed under GPL v3 or later.

A copy of the license is included in the root of the plugin's directory.  The file is named `LICENSE`.

### What About Other Features?
