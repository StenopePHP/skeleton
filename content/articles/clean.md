---
title:              "Clean the skeleton"
description:        "Whenever you feel ready and does not need anymore some of the features provided by the skeleton, you can remove them."
publishedAt:        "2022-09-12"
lastModified:       ~
tableOfContent:     2

image:              "content/images/articles/banners/clean.jpg"
tags:               ["dev", "stenope", "skeleton"]
authors:            ["ogi"]
---

Whenever you feel ready and does not need anymore some of the features provided by the skeleton, you can remove them.

## Styles

Remove the `assets/scss/skeleton-theme` directory and the `@import` from `assets/styles.scss` file.  
You shouldn't need to remove any dependency from `package.json` as the skeleton theme was only using a CDN.

## Models

Remove any unused modale from the `src/Model` directory.

You might also want to update the `config/packages/stenope.yaml` file to remove the references to models you don't need anymore.

## Templates

Remove any unused template from the `templates` directory.

## Controllers

Remove the `src/Controller/ArticleController.php` file, unless you adapted the model to your own needs.
Beware you might still have references to the following articles routes in your templates or `config/site.yaml`: 
- `article_show`
- `article_list`

## Contents

Remove any unused file from the `content/{articles,authors}` and `content/images/articles` directory.

## Images

### Automatic resize of content images

If you don't need the automatic resize of content images, you can remove
the `src/Bridge/Glide/Stenope/Processor/ResizeImagesContentProcessor.php` file and references to it in
the `config/services.yaml` file.

### Glide integration

If you don't need to resize image, or want to use your own tool or third-party integration, you can remove the embedded Glide bundle:

- the `config/packages/glide.yaml` file.
- reference to `GlideBundle` in `config/bundles.php`
- source code in `src/Bridge/Glide`

## Swup

If you don't need the Swup integration, you can remove the `assets/js/controllers/swup_plugins_controller.js` file,
update `templates/base.html.twig` to remove the `data-controller="swup-plugins"` attribute from the `body` tag:

```diff
-    <body
-        {{ stimulus_controller('swup_plugins')
-         | stimulus_controller('symfony/ux-swup/swup', {
-               // …
-           })
-        }}>
+    <body>
```

and run:

```shell
symfony composer remove symfony/ux-swup
npm uninstall @swup/debug-plugin @swup/fade-theme @swup/progress-plugin @swup/scroll-plugin @swup/slide-theme
```
