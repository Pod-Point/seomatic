<?php

namespace Craft;

interface ReviewsServiceInterface
{
    /**
     * Used to retrieve an array of reviews and stats about all reviews.
     *
     * @param string $uri
     * @param string $cacheId
     * @param array  $parameters
     *
     * @return array
     */
    public function getReviews(string $uri, string $cacheId = 'reviewsCache', array $parameters = []);

    /**
     * Used to retrieve formatted reviews.
     *
     * @param array $reviews
     * @param bool  $getStatistic
     *
     * @return array
     */
    public function transformReviews(array $reviews, bool $getStatistic = true);
}
