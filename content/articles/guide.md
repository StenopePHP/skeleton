---
title:              "Guide"
description:        "Learn more about writing contents with Stenope and this skeleton specificities."
publishedAt:        "2022-09-02"
lastModified:       ~
tableOfContent:     true

image:              "content/images/articles/banners/guide.jpg"
tags:               ["dev", "stenope", "skeleton"]
authors:            ["ogi"]
nextArticle:        "write-your-own-contents"
---

## What's inside

This skeleton contains some opinionated tools and configurations to help you start your project:

- Symfony 6.4 LTS, with AssetMapper component to handle frontend dependencies with no build.
- Sass integration
- Out-of-the-box [Swup](./swup.md) integration
- Glide integration to resize images on the fly from templates
- A Stenope custom processor to automatically resize images in contents with a Glide preset
- Page, Article and Author models, controllers & templates for rendering this documentation and help you discovering the
  way Stenope works.
- a basic 404 error page.
- A basic Github Workflow to [deploy to Github Pages](./deploy.md)
- A basic Github Workflow for automated tests and linting
- A catch-all route allowing to expose simple pages from Markdown files in the `content/pages` directory.

This might be a good start for wiring your own content-based application, but not everything might suit to your needs.  
Consult the [« Cleaning the skeleton » article](./clean.md) to get an overview of the related files.

## Writing content

### Basic pages

You can create simple pages from Markdown files in the `content/pages` directory out-of-the box, like the [About page](../pages/about.md).

The page will be accessible using the filename in URL. E.g: a `foo/bar.md` file will be accessible at `/foo/bar`.

Pages are rendered by default using the `page.html.twig` template, but each page can have its own. 
E.g: a `foo/bar.md` file will use the `foo/bar.html.twig` template if it exists.

### Articles

The articles sampled in this starter kit are written in Markdown, and are located in the `content/articles` directory.

The model used is the `src/Model/Article.php` class, which describes the available properties of an article.

You can start playing around by writing your own articles in the `content/articles` directory.

## Table of Content

The `TableOfContentProcessor` registered by default by Stenope allows you to get a structured object 
from your document titles by adding a `tableOfContent` property to your model:

```php
class Article {
    // […]
    /** 
     * Automatically populated by {@link TableOfContentProcessor} 
     */
    public ?TableOfContent $tableOfContent = null
    // […]
}
```

Using:

```yaml
tableOfContent: true
```

the `tableOfContent` property will be populated with a `TableOfContent` object you can use in your template to render a 
table of content:

```twig
{% if article.tableOfContent is not empty %}
    <ol class="table-of-content">
        {% for headline in article.tableOfContent %}
            <li class="table-of-content__item">
                <a href="#{{ headline.id }}">{{ headline.content }}</a>

                {% if headline.children is not empty %}
                    <ol class="table-of-content__sub-level">
                        {% for child in headline.children %}
                            <li>
                                <a href="#{{ child.id }}">{{ child.content }}</a>
                            </li>
                        {% endfor %}
                    </ol>
                {% endif %}
            </li>
        {% endfor %}
    </ol>
{% endif %}
```

!!! Note
    The table of content is generated from the `h2` to `h6` tags. The `h1` represents the article title.

You can also specify the depth of the table of content:

```yaml
tableOfContent: 3
```

## Links

### External links

External links automatically are opened in a new tab.

### Internal links to another content page

Any content managed by Stenope can be referenced from another content page using regular relative Markdown links:

```md
Discover [what is Stenope](./what-is-stenope.md)
```

Renders:

Discover [what is Stenope](./what-is-stenope.md)

See [the official documentation about linking contents](https://stenopephp.github.io/Stenope/link-contents/) to learn
more about the feature and how ton configure it.

## Images

### Using a relative path (recommended)

Images are referenced in the Markdown files using the `![alt](path)` syntax, where `path` is the path to the image file,
relative to the Markdown file:

![Exemple image with relative path](./../images/articles/guide/exemple-image.jpg)

```md
![Exemple image with relative path](./../images/articles/guide/exemple-image.jpg)
```

### Using absolute path

You can also reference the image using an absolute path, from the root of the project:

![Exemple image from project root](content/images/articles/guide/exemple-image.jpg)

```md
![Exemple image from project root](content/images/articles/guide/exemple-image.jpg)
```

!!! Note
    Actually, the "absolute" path is relative to the `glide.source` directory, which is defined 
    to `%kernel.project_dir%` in this app.

### Automatic image resizing & retina images

This skeleton showcases a custom `ResizeImagesContentProcessor` [processor](https://stenopephp.github.io/Stenope/cookbooks/processors/), 
which search for any images in the `content` property of your model, and resizes them to a specific width, 
using a Glide preset (`article_content` in our case).

This behavior is registered for the Article model, in the `services.yaml` file:

```yaml
    resize_images_content_processor.article:
        class: App\Bridge\Glide\Stenope\Processor\ResizeImagesContentProcessor
        arguments:
            $type: App\Model\Article
            $preset: article_content
            $projectDir: '%kernel.project_dir%'
```

Of course, this is only an arbitrary example, and you can register this processor for any model you want, or create your
own processor.

!!! Note
    GIFs cannot be resized by Glide, but can still be referenced.

![Test gif](./../images/articles/guide/exemple-gif.gif)  

```md
![Test gif](./../images/articles/guide/exemple-gif.gif)
```

### Resize image in templates

This starter kit comes with an embedded Glide bundle, which allows you to resize local images in your templates,
with predefined presets (defined in the `config/packages/glide.yaml` file):

```twig
{{ article.image|glide_image_preset('article_thumbnail') }}
```

See [Glide's documentation](https://glide.thephpleague.com/1.0/api/quick-reference/) for available options.
