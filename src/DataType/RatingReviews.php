<?php
/**
 * @file
 * Contaings \Triquanta\IziTravel\DataType\Rating
 */

namespace Triquanta\IziTravel\DataType;

use \Triquanta\IziTravel\DataType\Review;

class RatingReviews implements RatingReviewsInterface
{
    use PagingTrait;

    /**
     * The uuid.
     *
     * @var string
     */
    protected $uuid;

    /**
     * The rating average.
     *
     * @var float
     */
    protected $ratingAverage;

    /**
     * The amount of ratings.
     *
     * @var integer
     */
    protected $ratingsCount;

    /**
     * The amount of reviews.
     *
     * @var integer
     */
    protected $reviewsCount;

    /**
     * The date the rating was calculated.
     *
     * @var string
     */
    protected $date;

    /**
     * Array with reviews.
     *
     * @var \Triquanta\IziTravel\DataType\Review[]
     */
    protected $reviews;

    use FactoryTrait;

    public static function createFromData(\stdClass $data)
    {
        $rating = new static();
        $rating->uuid = $data->metadata->uuid;
        $rating->ratingAverage = $data->metadata->rating_average;
        $rating->ratingsCount = $data->metadata->ratings_count;
        $rating->reviewsCount = $data->metadata->reviews_count;
        $rating->date = $data->metadata->date;

        if (isset($data->paging)) {
            $rating->limit = $data->paging->limit;
            $rating->returnedCount = $data->paging->returned_count;
            $rating->totalCount = $data->paging->total_count;
        }

        $rating->reviews = [];
        if (isset($data->data) && count($data->data) > 0) {
            foreach ($data->data as $review_data) {
                $rating->reviews[] = Review::createFromJson(json_encode($review_data));
            }
        }

        return $rating;
    }

    public function getUuid()
    {
        return $this->uuid;
    }

    public function getRatingAverage()
    {
        return $this->ratingAverage;
    }

    public function getRatingsCount()
    {
        return $this->ratingsCount;
    }

    public function getReviewsCount()
    {
        return $this->reviewsCount;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getReviews()
    {
        return $this->reviews;
    }
}