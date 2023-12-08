<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Page;
use Stenope\Bundle\ContentManagerInterface;
use Stenope\Bundle\Exception\ContentNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Twig\Environment;

class DefaultController extends AbstractController
{
    public function __construct(
        private readonly ContentManagerInterface $contentManager,
        private readonly Environment $twig,
    ) {
    }

    #[Route('/', name: 'home')]
    public function home(): Response
    {
        return $this->render('home.html.twig');
    }

    /**
     * This route is used to display pages from `content/pages`.
     * Since this is a catch-all route, it has a very low priority.
     */
    #[Route('/{slug}', name: 'page', requirements: ['slug' => '[^\.]+'], priority: -500)]
    public function page(string $slug): Response
    {
        try {
            $page = $this->contentManager->getContent(Page::class, $slug);
        } catch (ContentNotFoundException $exception) {
            throw $this->createNotFoundException(sprintf(
                'Page not found. Did you forget to create a `content/pages/%s.md` file?',
                $slug,
            ), $exception);
        }

        // You can create a custom template for each page, named after its slug,
        // (e.g: For "foo/bar.md" file => use "foo/bar.html.twig")
        // or use the generic "page.html.twig" one.
        if (!$this->twig->getLoader()->exists($template = "$slug.html.twig")) {
            $template = 'page.html.twig';
        }

        return $this->render($template, ['page' => $page]);
    }
}
