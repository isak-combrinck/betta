# Betta

*Your friendly neighborhood compiler.*

Helps you code websites efficiently.

## Version 0.0.1

Betta is currently under early development.
- Use in production at your own risk.
- No documentation is provided at the moment.

### Websites using Betta

- [Stiftung Grosshaus](https://www.grosshaus.ch/)
- [Living Decor](https://www.livingdecor.org/)
- [Combrinck Dev.](https://combrinck.dev/)
- [Café Friedegg](https://friedegg.ch/)



## Usage

Betta expects a directory structure like this:

```
yourproject/
  betta/
  build/
  src/
    _data/
    css/
    icons/
    images/
    js/
    page_elements/
    pages/
    .htaccess
    favicon.png
    settings.php
```

- `betta` is a clone of the betta repository, you can add it as a submodule to stay up to date. Just make sure you have the time to fix breaking changes before pulling.
- `src` is where you write your code.

  - The `_data` directory may contain sensitive information and access to it should be restricted to the server. People should not be able to directly access resources in it by using a url. Typing `/_data/pictures/cat.jpg` should present the people with an access restricted page (automatically generated by the server, if you set the access rights correctly), not a picture of a cat.
  - `css` contains your CSS files.
  - `icons` contains icons used in your site, the entire folder can be omitted if you don't use any icons.
  - `images` contains images used in your site, can be omitted if you don't use images.
  - `js` contains your JavaScript code.
  - `page_elements` contains HTML or PHP files that contain code snippets used in multiple places in your project. Like the navigation menu.
  - `pages` contains HTML or PHP files and sub-folders. The structure used here determines the final structure of your website. **This is where you will do most of your work.**
  - You can provide a `.htaccess` file for your server.
  - Your favicon can be in the `.png` or `.ico` format (use lowercase).
  - `settings.php` contains your settings for the Betta compiler.

*I am moving away from including icons and images in the repository for a website, no matter how small. I recommended to not use the icons and images folders. Instead, use a subdomain to host static assets for your website. Static hosting is easy to set up and can help boost your site's performance; most importantly it allows you to swap out images without touching the code, which is worth a lot.*
