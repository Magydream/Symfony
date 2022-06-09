<?php

namespace App\Controller;

use App\Entity\Conference;
use App\Repository\CommentRepository;
use App\Repository\ConferenceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConferenceController extends AbstractController
{
    #[Route('/', name: 'app_conference')]

    public function index(ConferenceRepository $conferenceRepository,Request $request,): Response
    {
        $citys = $conferenceRepository->getListCity();
        $city_search = $request->query->get('city_search','');
        $years = $conferenceRepository->getListYear();
        $years_search = $request->query->get('year_search','');
        $search_city = $request->query->get('search_city','');
        $offset = max(0,$request->query->getInt('offset',0));
        $paginator = $conferenceRepository->getConferencePaginator($offset,$city_search,$years_search,$search_city);
        return $this->render('conference/index.html.twig', [
            'citys' => $citys,
            'city_search' => $city_search,
            'year_search' => $years_search,
            'search_city' => $search_city,
            'years' => $years,
            'conferences' => $paginator,
            'previous' => $offset - ConferenceRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($paginator),$offset + ConferenceRepository::PAGINATOR_PER_PAGE)
        ]);
    }
    #[Route('/conference/{id}', name: 'ficheConference')]
    public function show(Conference $conference,CommentRepository $commentRepository,Request $request): Response
    {
        $offset = max(0,$request->query->getInt('offset',0));
        $paginator = $commentRepository->getCommentPaginator($conference,$offset);
        return $this->render('conference/show.html.twig', [
            'conference' => $conference,
            'comments' => $paginator,
            'previous' => $offset - CommentRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($paginator),$offset + CommentRepository::PAGINATOR_PER_PAGE)
        ]);
    }
}
