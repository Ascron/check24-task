<?php declare(strict_types=1);

namespace Ascron\Check24Task\Controllers;

use Ascron\Check24Task\App;
use Ascron\Check24Task\Exceptions\Http\NotFoundException;
use Ascron\Check24Task\Repository\ArticleRepository;

class ArticleController extends AbstractController
{
    private ArticleRepository $articleRepository;

    public function beforeAction(App $app)
    {
        parent::beforeAction($app);

        $this->articleRepository = new ArticleRepository($app->getDatabaseConnection());
    }

    /**
     * Handles GET requests to /article/show and /article/show/{id}
     * Show one article details
     * @return void
     */
    public function getShow(array $parameters = [])
    {

    }

    /**
     * Handle GET requests to /article/list and /article/list/{page}
     * Show all articles with pagination
     *
     * @param array $parameters
     * @return string
     */
    public function getList(array $parameters = []): string
    {
        $page = 0;
        if ($parameters !== []) {
            [$page] = $parameters;
        }

        if (!is_numeric($page)) {
            throw new NotFoundException();
        }
        $page = (int)$page;

        $articlesPerPage = (int)$_ENV['ARTICLES_PER_PAGE'];

        $articles = $this->articleRepository->getList($articlesPerPage, ($page - 1) * $articlesPerPage);
        return $this->app->getView()->render('article_list', ['articles' => $articles]);
    }

    /**
     * Handle POST requests to /article/create
     * Create new article
     *
     * @param array $parameters
     * @return void
     */
    public function postCreate(array $parameters = [], array $formData = [])
    {

    }
}