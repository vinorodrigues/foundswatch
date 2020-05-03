# Foundswatch

![](https://foundswatch.com/img/logo.png)

Foundswatch is a collection of open source themes for Foundation for Sites. Check it out at [foundswatch.com](https://foundswatch.com/).

## Usage

There are a few different ways you can integrate Foundswatch into your project.

### Via Pre-complied Asset

Download the `foundation.min.css` file associated with a theme and replace Foundation's default stylesheet. You must still include Foundation's JavaScript file to have functional dropdowns, modals, etc.

### Via CDN

Similar to above, but you can hotlink to the appropriate `foundation.min.css` hosted on [jsdelivr.com](https://www.jsdelivr.com/package/gh/vinorodrigues/foundswatch). [![](https://data.jsdelivr.com/v1/package/gh/vinorodrigues/foundswatch/badge?style=rounded)](https://www.jsdelivr.com/package/gh/vinorodrigues/foundswatch)

### Via Sass Imports

If you're using Sass (SCSS) in your project, you can import the `_settings.scss` and `_foundswatch.scss` files for a given theme. This method allows you to override theme variables.

```
@import 'settings';             // *Foundswatch variant
@import '../scss/foundation';   // Zurb Foundation 6
@include foundation-everything;
@import 'foundswatch';          // *Foundswatch variant
```

Make sure to import Foundation's `foundation.scss` in between `_settings.scss` and `_foundswatch.scss`!

## Source Installation

Once you have downloaded the Git then you will need:

* [Homebrew](https://brew.sh/) (for macOS users)
* [Node.js](https://nodejs.org/) (using Homebrew): `brew install node`
* [Gulp](https://gulpjs.com/) (using NPM): `npm install --global gulp-cli`
* `npm insatll jquery`
* `npm install what-input`
* [Foundation 6 for Sites](https://get.foundation/sites.html) (Sass version, using NPM): `npm install foundation-sites`

## Installation issues

If you're having issues with GEM or NPM try reading these:

* [Developer Headaches on macOS Catalina](https://medium.com/faun/macos-catalina-xcode-homebrew-gems-developer-headaches-cf7b1edf10b7)


## Customisation

Foundswatch is open source and you’re welcome to modify the themes.

Each theme consists of two SASS files. `_settings.scss`, which is included by default in Foundation, allows you to customize the settings. `_foundswatch.scss` introduces more extensive structural changes.

Check out the Help page for more details on building your own theme.

## Contributing

It's through your contributions that Foundswatch will continue to improve. You can contribute in several ways.

**Issues:** Provide a detailed report of any bugs you encounter and open an issue on GitHub.

**Documentation:** If you'd like to fix a typo or beef up the docs, you can fork the project, make your changes, and submit a pull request.

**Code:** Make a fix and submit it as a pull request. When making changes, it's important to keep the CSS and SASS versions in sync. To do this, be sure to edit the SASS source files for the particular theme first, then run the tasks grunt swatch to build the CSS.

**Changelog:** Keep track of the changes and releases in the [changelog file](CHANGELOG.md)

**Donation:** Donations are gratefully accepted via GitHub and [Patreon](https://www.patreon.com/vinorodrigues).

## Author

Vino Rodrigues

* [vinorodrigues.com](https://vinorodrigues.com/)
* __Github__ [@vinorodrigues](https://github.com/vinorodrigues)

## Thanks

* [ZURB](https://zurb.com/) for making the [Foundation](http://get.foundation) CSS framework
* [Thomas Park](https://thomaspark.co/) ([@thomaspark](https://github.com/thomaspark)) for [Bootswatch](https://bootswatch.com/).

## Copyright and License

&#169; 2020 Vino Rodrigues

Code released under the [MIT License](LICENSE.md).
