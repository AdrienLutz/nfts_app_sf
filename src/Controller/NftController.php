<?php

namespace App\Controller;

use App\Entity\NFT;
use App\Form\NftType;
use App\Form\SearchType;
use App\Repository\NFTRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Http\Attribute\IsGranted;





class NftController extends AbstractController
{
    #[Route('/nft', name: 'app_nft')]
//    public function index(NFTRepository $NFTRepository,  Request $request): Response
        public function index(NFTRepository $NFTRepository,  Request $request, PaginatorInterface $paginator): Response
    {
//        $nfts = $paginator->paginate(
//            $NFTRepository -> findAll(),
//            $request->query->getInt('page', 1),
//            10
//        );


//        $nfts = $NFTRepository -> findAll();
        $nfts = $NFTRepository ->  findBy(["valeur" => 200], ['valeur' => 'ASC'], 3);

        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $filters = $form->getData();
            $nfts = $NFTRepository->searchEngine($filters);
        }

        return $this->render('nft/index.html.twig', [
            'nfts' => $nfts,
            'searchForm' => $form->createView()
        ]);
    }
    #[Route('/nft/account', name: 'app_nft_user')]
    #[IsGranted("ROLE_USER")]
    public function nftUserId(NFTRepository $NFTRepository,  Request $request): Response
    {

        $nfts = $NFTRepository -> findAll();

        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $filters = $form->getData();
            $nfts = $NFTRepository->searchEngine($filters);
        }
        return $this->render('nft/account.html.twig', [
            'nfts' => $nfts,
            'searchForm' => $form->createView()
        ]);
    }

    #[Route('/nft/add', name: 'app_nft_form')]
    #[IsGranted('ROLE_USER')]

    public function nftAjout(Request $request, SluggerInterface $slugger, EntityManagerInterface $em): Response
    {
        $form = $this-> createForm(NftType::class, new NFT());
        $form->handleRequest($request);


        if($form-> isSubmitted() && $form->isValid()){
            $image = $form->get('image')->getData();
            if(is_null($image)){
                $error = new FormError("Veuillez uploader une image");
                $form -> get('image') -> addError($error);
            } else {
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$image->guessExtension();
                try {
                    $image->move(
                        $this->getParameter('nft_image_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    dd($e);
                }

                $form = $form->getData();
                $form->setImage($newFilename);
                $form->setUserAdd($this->getUser());
                $em->persist($form);
                $em->flush();
                return $this->redirectToRoute('app_nft_user');

            }
        }

        return $this->render('nft/form.html.twig', [
            'form' => $form ->createView()
        ]);
    }
}
