<?php

namespace App\Controller;




use App\Entity\Users;
use App\Entity\UsersSearch;
use App\Form\UsersSearchType;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;

class BaseController extends AbstractController
{

    /**
     * @var UsersRepository
     */
    private $usersRepository;

    /**
     * @var Environment
     */
    private $render;

    /**
     * @var EntityManagerInterface
     */
    private $em;


    public function __construct(EntityManagerInterface $em,  UsersRepository $usersRepository, Environment $render)
    {

        $this->usersRepository = $usersRepository;
        $this->render = $render;
        $this->em = $em;
    }

    public function home()
    {

        return $this->render("pages/home.html.twig", [
        ]);
    }


    public function list(Request $request,PaginatorInterface $paginator)
    {
        $user = new Users();
        $search = new UsersSearch();
        $form_search = $this->createForm(UsersSearchType::class,$search);
        $form_search->add('besoins',ChoiceType::class,[
            'choices' => $user->getBesoinsFromJson()
            ]);

        $form_search->handleRequest($request);


        $page = $request->get('page',1);
        $result = $this->usersRepository->findAllByState($search);
        if ($result == null) {
            $result = [];
        }
        $length = sizeof($result);
        $users = $paginator->paginate($result,$page,15);

        return $this->render('pages/users.list.html.twig',[
            'length' => $length,
            'search_form' => $form_search->createView(),
            'users' => $users
        ]);

    }




}
/*
 *  {{ form_start(form) }}

                                <!-- Email Adress input-->
                                <div class="form-floating mb-3">
                                    <div class="form-control">
                                        {{ form_label(form.email) }}
                                        {{ form_widget(form.email) }}
                                        <small>{{ form_help(form.email) }}</small>
                                        <div class="form-error">
                                            {{ form_errors(form.email) }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Object  input-->
                                <div class="form-floating mb-3">
                                    <div class="form-control">
                                        {{ form_label(form.object) }}
                                        {{ form_widget(form.object) }}
                                        <small>{{ form_help(form.object) }}</small>
                                        <div class="form-error">
                                            {{ form_errors(form.object) }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Object  input-->
                                <div class="form-floating mb-3">
                                    <div class="form-control">
                                        {{ form_label(form.motif) }}
                                        {{ form_widget(form.motif) }}
                                        <small>{{ form_help(form.motif) }}</small>
                                        <div class="form-error">
                                            {{ form_errors(form.motif) }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Object  input-->
                                <div class="form-floating mb-3">
                                    <div class="form-control">
                                        {{ form_label(form.message) }}
                                        {{ form_widget(form.message) }}
                                        <small>{{ form_help(form.message) }}</small>
                                        <div class="form-error">
                                            {{ form_errors(form.message) }}
                                        </div>
                                    </div>
                                </div>


                                {{ form_end(form) }}
 */


