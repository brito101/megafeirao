<?php

namespace LaraCar\Support;

use CoffeeCode\Optimizer\Optimizer;

/**
 * FSPHP | Class Seo
 *
 * @author Robson V. Leite <cursos@upinside.com.br>
 * @package Source\Support
 */
class Seo {

    /** @var Optimizer */
    protected $optimizer;

    /**
     * Seo constructor.
     * @param string $schema
     */
    public function __construct(string $schema = "article") {
        $this->optimizer = new Optimizer();
        $this->optimizer->openGraph(
                env('APP_NAME'),
                'pt_BR',
                'article',
        )->twitterCard(
                env('CLIENT_SOCIAL_TWITTER_CREATOR'),
                env('CLIENT_SOCIAL_TWITTER_PUBLISHER'),
                env('APP_URL')
        )->publisher(
                env('CLIENT_SOCIAL_FACEBOOK_PAGE'),
                env('CLIENT_SOCIAL_FACEBOOK_AUTHOR'),
                env('CLIENT_SOCIAL_GOOGLE_PAGE'),
                env('CLIENT_SOCIAL_GOOGLE_AUTHOR')
        )->facebook(
                env('CLIENT_SOCIAL_FACEBOOK_APP')
        );
    }

    /**
     * @param string $title
     * @param string $description
     * @param string $url
     * @param string $image
     * @param bool $follow
     * @return string
     */
    public function render(string $title, string $description, string $url, string $image, bool $follow = true): string {
        return $this->optimizer->optimize($title, $description, $url, $image, $follow)->render();
    }

    /**
     * @return Optimizer
     */
    public function optimizer(): Optimizer {
        return $this->optimizer;
    }

    /**
     * @param string|null $title
     * @param string|null $desc
     * @param string|null $url
     * @param string|null $image
     * @return null|object
     */
    public function data(?string $title = null, ?string $desc = null, ?string $url = null, ?string $image = null) {
        return $this->optimizer->data($title, $desc, $url, $image);
    }

}
