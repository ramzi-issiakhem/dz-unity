<?php

namespace App\Controller;




use App\Entity\Users;
use App\Entity\UsersSearch;
use App\Form\UsersSearchType;
use App\Form\UsersType;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;

class AdminController extends AbstractController
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



    public function createUser(Request $request)
    {

        $user = new Users();
        $user->setState(true);

        $form = $this->createForm(UsersType::class,$user);
        $form->add('besoins',ChoiceType::class,[
            "choices" => $user->getBesoinsFromJson(true),
            "multiple" => true
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($user);
            $this->em->flush();
            $this->addFlash('success',"Association/Point de collecte crée avec succes");
            return $this->redirectToRoute('admin.panel');

        }


        return $this->render("pages/admin/admin.create.user.html.twig", [
            'form' => $form->createView()
        ]);
    }

    public function edit(Users $user,Request $request) {

        $form = $this->createForm(UsersType::class,$user);
        $form->add('besoins',ChoiceType::class,[
            "choices" => $user->getBesoinsFromJson(true),
            "multiple" => true
        ])->add('state',ChoiceType::class,[
            "choices" => array_flip([true => "Activé",false => "Desactivé"])
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success',"Association/Point de collecte edité avec succes");
            return $this->redirectToRoute('admin.panel');
        }

        return $this->render("pages/admin/admin.user.edit.html.twig",[
            'form' => $form->createView()
        ]);
    }

    public function panel() {

        $users = $this->usersRepository->findAllOrdered();

        return $this->render("pages/admin/admin.panel.html.twig",[
            "users" => $users
        ]);
    }

    public function removeUser(Users $user,Request $request) {

        if ($this->isCsrfTokenValid('remove' . $user->getId(),$request->get("_token"))) {
            $this->em->remove($user);
            $this->em->flush();
            $this->addFlash('success','Utilisateur supprimé avec succes');
            return $this->redirectToRoute('admin.panel');
        }

        return $this->redirectToRoute('admin.panel');
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


