<?php

namespace Universibo\Bundle\WebsiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Universibo\Bundle\LegacyBundle\Entity\Canale;

/**
 */
class ForumController extends Controller
{
    public function boxAction($channelId)
    {
        $channel = $this->get('universibo_legacy.repository.canale2')->find($channelId);
        if (!$channel instanceof Canale) {
            throw new NotFoundHttpException('Channel not found');
        }

        $postDao = $this->get('universibo_forum.dao.post');
        $forumRouter = $this->get('universibo_forum.router');

        $forumId = $channel->getForumForumId();
        $forumUri = $forumRouter->getForumUri($forumId);

        $posts = [];
        foreach ($postDao->getLatestPosts($forumId, 10) as $post) {
            $posts[] = [
                'title' => $post['topic_title'],
                'uri'   => $forumRouter->getPostUri($post['min'])
            ];
        }

        $response = $this->render('UniversiboWebsiteBundle:Forum:box.html.twig', [
            'posts'     => $posts,
            'forumUri'  => $forumUri,
            'channelId' => $channel->getIdCanale()
        ]);

        $response->setSharedMaxAge(60);
        $response->setPublic();

        return $response;
    }
}
