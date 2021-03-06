<?php

namespace WCS\ShareKanBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WCS\ShareKanBundle\Entity\Playlist;
use WCS\ShareKanBundle\Entity\Share;
use WCS\ShareKanBundle\Entity\Tag;

class PlaylistController extends Controller
{
    public function addAction(Request $request)
    {
//        if($request->isXmlHttpRequest()){
            $em = $this->getDoctrine()->getManager();
            $playlist = new Playlist();
            $playlist->setNom($request->request->get("title"));
            $playlist->setUrls(array(
                $request->request->get("title1")=> $request->request->get("url1"),
                $request->request->get("title2")=> $request->request->get("url2"),
                $request->request->get("title3")=> $request->request->get("url3")
            ));
            $playlist->setCreator($this->get('security.token_storage')->getToken()->getUser());
            $playlist->setDatetime(new \DateTime());
            $playlist->setPublic(true);
            $tagsarr = explode(',', $request->request->get("tags"));
            $playlist->setTags($tagsarr);
            $playlist->setVote(0);
            $em->persist($playlist);
            $em->flush();
            return new JsonResponse(array('error' => false));
//        }
//        else{
//            return new JsonResponse(array(
//                'error' => true,
//                "error_message" => "Merci d'envoyer une requête AJAX"
//            ));
//        }
    }
    public function deleteAction(Request $request)
    {
//        if($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            $jsondata = json_decode($request->request);
            $playlist = $em->getRepository('WCSShareKanBundle:Playlist')->find($jsondata["id"]);
            $em->remove($playlist);
            $em->flush();
            return new JsonResponse(array('error' => false));
//        }
//        else{
//            return new JsonResponse(array(
//                'error' => true,
//                "error_message" => "Merci d'envoyer une requête AJAX"
//            ));
//        }
    }
    public function updateAction(Request $request)
    {
//        if($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            $jsondata = json_decode($request->request);
            $playlist = $em->getRepository('WCSShareKanBundle:Playlist')->find($jsondata["id"]);
            if ($jsondata["shares"]){
                foreach($jsondata["shares"] as $shareurl){
                    $share = new Share();
                    $share->setUrl($shareurl);
                    $share->setPlaylist($playlist);
                    $playlist->addShare($share);
                    $em->persist($share);
                }
            }
            if ($jsondata["public"]) {
                $playlist->setPublic($jsondata["public"]);
            }
            if ($jsondata["tags"]) {
                foreach($jsondata["tags"] as $tagsname){
                    $tag = $em->getRepository('WCSShareKanBundle:Tag')->findOneByTag($tagsname);
                    if (!$tag){
                        $tag = new Tag();
                        $tag->setTag($tagsname);
                        $em->persist($tag);
                    }
                    $playlist->addTag($tag);
                }
            }
            if ($jsondata["vote"]) {
                $playlist->setVote($jsondata["vote"]);
            }
            $em->persist($playlist);
            $em->flush();
            return new JsonResponse(array('error' => false));
//        }
//        else{
//            return new JsonResponse(array(
//                'error' => true,
//                "error_message" => "Merci d'envoyer une requête AJAX"
//            ));
//        }



    }
    public function getAction(Request $request)
    {
//        if($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            $jsondata = json_decode($request->request);
            $playlist = $em->getRepository('WCSShareKanBundle:Playlist')->find($jsondata["id"]);
            return new Response($this->container->get('jsonparse')->toJson($playlist));
//        }
//        else{
//            return new JsonResponse(array(
//                'error' => true,
//                "error_message" => "Merci d'envoyer une requête AJAX"
//            ));
//        }
    }
    public function getallAction(Request $request)
    {

            $em = $this->getDoctrine()->getManager();
            $playlists = $em->getRepository('WCSShareKanBundle:Playlist')->findBy(array(), array('id' => 'DESC'));
            $jsonContent = $this->container->get('jsonparse')->toJson($playlists);

            return new Response($jsonContent);
    }
}
