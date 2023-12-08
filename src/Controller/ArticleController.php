<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Article;
use Stenope\Bundle\ContentManagerInterface;
use Stenope\Bundle\Service\ContentUtils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/articles')]
class ArticleController extends AbstractController
{
    public function __construct(private readonly ContentManagerInterface $manager)
    {
    }

    #[Route('/', name: 'article_list')]
    public function list(): Response
    {
        $articles = $this->manager->getContents(Article::class, ['publishedAt' => true], '_.isPublished()');

        return $this->render('articles/list.html.twig', [
            'articles' => $articles,
        ])->setLastModified(ContentUtils::max($articles, 'lastModifiedOrCreated'));
    }

    #[Route('/{article}', name: 'article_show', requirements: ['article' => '.+'])]
    public function show(Article $article): Response
    {
        return $this->render('articles/show.html.twig', [
            'article' => $article,
        ])->setLastModified($article->getLastModifiedOrCreated());
    }
}
