<?php

namespace WCS\ShareKanBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * playlist
 *
 * @ORM\Table(name="playlist")
 * @ORM\Entity(repositoryClass="WCS\ShareKanBundle\Repository\playlistRepository")
 */
class Playlist
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datetime", type="datetime")
     */
    private $datetime;

    /**
     * @var bool
     *
     * @ORM\Column(name="public", type="boolean")
     */
    private $public;

    /**
     * @var int
     *
     * @ORM\Column(name="vote", type="integer")
     */
    private $vote;

    /**
     * @ORM\OneToMany(targetEntity="Share", mappedBy="Playlist", cascade={"remove"})
     */
    private $shares;

    /**
     * @ORM\ManyToMany(targetEntity="Tag", mappedBy="Playlist")
     */
    private $tags;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="Playlists")
     */
    private $creator;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set datetime
     *
     * @param \DateTime $datetime
     *
     * @return playlist
     */
    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;

        return $this;
    }

    /**
     * Get datetime
     *
     * @return \DateTime
     */
    public function getDatetime()
    {
        return $this->datetime;
    }

    /**
     * Set public
     *
     * @param boolean $public
     *
     * @return playlist
     */
    public function setPublic($public)
    {
        $this->public = $public;

        return $this;
    }

    /**
     * Get public
     *
     * @return bool
     */
    public function getPublic()
    {
        return $this->public;
    }

    /**
     * Set vote
     *
     * @param integer $vote
     *
     * @return playlist
     */
    public function setVote($vote)
    {
        $this->vote = $vote;

        return $this;
    }

    /**
     * Get vote
     *
     * @return int
     */
    public function getVote()
    {
        return $this->vote;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->shares = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add share
     *
     * @param \WCS\ShareKanBundle\Entity\Share $share
     *
     * @return Playlist
     */
    public function addShare(\WCS\ShareKanBundle\Entity\Share $share)
    {
        $this->shares[] = $share;

        return $this;
    }

    /**
     * Remove share
     *
     * @param \WCS\ShareKanBundle\Entity\Share $share
     */
    public function removeShare(\WCS\ShareKanBundle\Entity\Share $share)
    {
        $this->shares->removeElement($share);
    }

    /**
     * Get shares
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getShares()
    {
        return $this->shares;
    }

    /**
     * Add tag
     *
     * @param \WCS\ShareKanBundle\Entity\Tag $tag
     *
     * @return Playlist
     */
    public function addTag(\WCS\ShareKanBundle\Entity\Tag $tag)
    {
        $this->tags[] = $tag;

        return $this;
    }

    /**
     * Remove tag
     *
     * @param \WCS\ShareKanBundle\Entity\Tag $tag
     */
    public function removeTag(\WCS\ShareKanBundle\Entity\Tag $tag)
    {
        $this->tags->removeElement($tag);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set creator
     *
     * @param \WCS\ShareKanBundle\Entity\User $creator
     *
     * @return Playlist
     */
    public function setCreator(\WCS\ShareKanBundle\Entity\User $creator = null)
    {
        $this->creator = $creator;

        return $this;
    }

    /**
     * Get creator
     *
     * @return \WCS\ShareKanBundle\Entity\User
     */
    public function getCreator()
    {
        return $this->creator;
    }
}