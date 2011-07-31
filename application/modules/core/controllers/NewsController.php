<?php 

class NewsController extends Extzf_Controller {


    /**
     * Reply news data
     *
     * @remotable
     * @return array
     */
    public function directread()
    {
        // Fetch news
        $news = $this->entityManager->createQuery('select n from Extzf\Model\News n ORDER BY n.timestamp DESC')
                      ->getArrayResult();

        return array(
            "total" => sizeof($news),
            "data" => $news
        );
    }


    /**
     * Update a news
     *
     * @remotable
     * @return array
     */
    public function directupdate($data)
    {
        $news = $this->entityManager->createQuery('select n from Extzf\Model\News n WHERE n.id = :newsId')
                      ->setParameter('newsId', $data->id)
                      ->getResult();

        if (sizeof($news) > 0) {
            $news = $news[0];

            $news->title = $data->title;
            $news->text = $data->text;

            $this->entityManager->persist($news);
            $this->entityManager->flush();
        }
        return true;
    }


    /**
     * Create a new news
     *
     * @remotable
     * @return array
     */
    public function directcreate($data)
    {
        $newNews = new Extzf\Model\News();
        $newNews->title = $data->title;
        $newNews->text = $data->text;
        $newNews->authorUserId = 1; // Static for this sample
        $newNews->timestamp = new \DateTime("now");

        $this->entityManager->persist($newNews);
        $this->entityManager->flush();

        return true;
    }


    /**
     * Destroys a news
     *
     * @remotable
     * @return array
     */
    public function directdestroy($data)
    {
        $news = $this->entityManager->createQuery('select n from Extzf\Model\News n WHERE n.id = :newsId')
                      ->setParameter('newsId', $data->id)
                      ->getResult();
                                                              
        if (sizeof($news) > 0) {
            $news = $news[0];

            $this->entityManager->remove($news);
            $this->entityManager->flush();

            return true;
        }
        return false;
    }
}