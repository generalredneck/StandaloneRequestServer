<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RequestRepository")
 * @ORM\Table(name="requests")
 */
class Request
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="text")
     */
    protected $artist;

    /**
     * @ORM\Column(type="text")
     */
    protected $title;

    /**
     * @ORM\Column(type="text")
     */
    protected $singer;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $request_time;



    // add your own fields

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of artist
     */
    public function getArtist()
    {
        return $this->artist;
    }

    /**
     * Set the value of artist
     *
     * @return  self
     */
    public function setArtist($artist)
    {
        $this->artist = $artist;

        return $this;
    }

    /**
     * Get the value of title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of singer
     */
    public function getSinger()
    {
        return $this->singer;
    }

    /**
     * Set the value of singer
     *
     * @return  self
     */
    public function setSinger($singer)
    {
        $this->singer = $singer;

        return $this;
    }

    /**
     * Get the value of request_time
     */
    public function getRequest_time()
    {
        return $this->request_time;
    }

    /**
     * Set the value of request_time
     *
     * @return  self
     */
    public function setRequest_time($request_time)
    {
        if (is_int($request_time)) {
            $timestamp = $request_time;
            $request_time = new \DateTime();
            $request_time->setTimestamp($timestamp);
        }
        $this->request_time = $request_time;

        return $this;
    }
}
