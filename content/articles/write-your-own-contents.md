---
title:              "Writing your own contents"
description:        "Take control over your app and start creating your own models, contents and templates"
publishedAt:        "2022-09-03"
lastModified:       ~
tableOfContent:     true

image:              "content/images/articles/banners/writing-your-own-contents.jpg"
tags:               ["dev", "stenope"]
authors:            ["ogi"]
nextArticle:        "clean"
---

First of all, you can start by reading the [Stenope documentation](https://stenopephp.github.io/Stenope/loading-content/#setup).

Since this skeleton already showcases writing blog-post like content, using Markdown, 
let's take another example and use a different format.

Let's say you'd like to expose galleries of images somewhere in your app.

## Model

Start by creating your model in `src/Model/Gallery.php`:

```php
namespace App\Model;

use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

class Gallery
{
    public function __construct(
        public string $slug,
        public string $title,
        public string $description,
        #[Context([DateTimeNormalizer::FORMAT_KEY => 'Y-m-d'])]
        public \DateTime $createdAt,
        public bool $published = true,
    ) {
    }
}
```

Our gallery consists of a `title`, a `description` a `creation date` and a `published/unpublished` status.  
The `slug` property is automatically injected by Stenope, and consists of the content filename.

Let's add a property holding an array of images:

```diff
class Gallery
{
    public function __construct(
        public string $slug,
        public string $title,
        public string $description,
+        /** @var GalleryImage[] */
+        public array $images,
        #[Context([DateTimeNormalizer::FORMAT_KEY => 'Y-m-d'])]
        public \DateTime $createdAt,
        public bool $published = true,
    ) {
    }
}
```

and a dedicated model:

```php
namespace App\Model;

class GalleryImage
{
    public function __construct(
        public string $path,
        public ?string $title = null,
        public ?string $description = null,
    ) {
    }
}
```

Each image will have a mandatory path on the filesystem, and an optional title and description.

## Configuration

Let's now indicate to Stenope where our gallery contents will be stored:

```yaml
# config/packages/stenope.yaml
stenope:
    providers:
        # […]
        App\Model\Gallery: '%kernel.project_dir%/content/galleries'
```

## Writing your first content

For our use-case, since we do not have a main textual content, like we do with our articles in markdown, we'll use YAML
as a structured format for our galleries.

Let's create a first gallery in `content/galleries/christmas.yaml`:

```yaml
title: Christmas photos
description: A gallery of Christmas photos
createdAt: "2020-12-25"

images:
    - { path: 'images/galleries/christmas/img1.jpg', title: 'Image 1', description: 'Some description' }
    - { path: 'images/galleries/christmas/img2.jpg', title: 'Image 2' }
    - { path: 'images/galleries/christmas/img3.jpg' }
```

!!! Note
    The images paths are place in the `public/images` directory so that they are accessible from the web directly.  
    In case you need to resize them, you can use the [Glide integration described in the guide](./guide.md).  
    In such case, the orignals does not need to be in the `public` directory,
    unless you want to let your user download it for instance.

## Controller

Now, we need to create a controller action for each pages we want to expose our galleries.  
We'll start with a simple list of galleries and a detail page for each:

```php
namespace App\Controller;

use App\Model\Gallery;
use Stenope\Bundle\ContentManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/galleries')]
class GalleryController extends AbstractController
{
    public function __construct(private readonly ContentManagerInterface $manager)
    {
    }

    #[Route('/', name: 'gallery_list')]
    public function list(): Response
    {
        $galleries = $this->manager->getContents(
            Gallery::class,
            sortBy: ['createdAt' => false], // Sort by creation date, descending
            filterBy: '_.published', // Filters out unpublished galleries
        );

        return $this->render('galleries/list.html.twig', [
            'galleries' => $galleries,
        ]);
    }

    #[Route('/{gallery}', name: 'gallery_show', requirements: ['gallery' => '.+'])]
    public function show(Gallery $gallery): Response
    {
        return $this->render('galleries/show.html.twig', [
            'gallery' => $gallery,
        ]);
    }
}
```

This controller makes use of the `ContentManagerInterface` to fetch, sort and filter contents managed by Stenope.  

Learn more on the documentation about:
- [Fetching](https://stenopephp.github.io/Stenope/loading-content/#fetching-a-specific-content)
- [Sorting](https://stenopephp.github.io/Stenope/loading-content/#sorting-contents)
- [Filtering](https://stenopephp.github.io/Stenope/loading-content/#filtering-contents)

## Templates

Let's create the templates for each controller:

**List**:

```twig
{# templates/galleries/list.html.twig #}
{% extends 'base.html.twig' %}

{% block meta_title 'List of galleries' %}

{% block content %}
    <h1>Galleries</h1>

    <ul>
        {% for gallery in galleries %}
            <li>
                <a href="{{ path('gallery_show', { gallery: gallery.slug }) }}">
                    {{ gallery.title }}
                </a>
            </li>
        {% endfor %}
    </ul>
{% endblock %}

```

**Show**:

```twig
{# templates/galleries/show.html.twig #}
{% extends 'base.html.twig' %}

{% block meta_title gallery.title %}

{% block content %}
    <h1>{{ gallery.title }}</h1>

    <small>Created on {{ gallery.createdAt|date('Y-m-d') }}</small>

    <p>{{ gallery.description }}</p>

    {% for image in gallery.images %}
        <figure>
            <img src="{{ asset(image.path) }}" alt="{{ image.title }}">
            <figcaption>{{ image.description }}</figcaption>
        </figure>
    {% endfor %}
{% endblock %}
```

!!! Note
    We use the [`{{ asset() }}`](https://symfony.com/doc/current/reference/twig_reference.html#asset) function 
    to generate the image path, so that it is correctly prefixed with the app base URL, if any.

## Referencing your content pages

Our galleries are now available at `/galleries` and `/galleries/{slug}` path, but there is no link pointing to these pages,
so it'll be excluded from the static build, since unreachable.

Let's add a link to our galleries listing in the main menu:

```yaml
# config/site.yaml
twig:
  globals:
    site:
      #[…]

      menu:
        - { path: 'home', label: 'Home' }
        - { path: 'article_list', label: 'Articles', children: ['article_show'] }
        - { path: 'gallery_list', label: 'Galleries', children: ['gallery_show'] }
```

Of course this is just an exemple using the skeleton layout. Adapt to your own needs!
