<?php

namespace App\Controllers;

use App\Database\Database;
use App\Http\Request;
use App\Http\Response;
use App\Models\Owner;
use App\Models\Project;
use App\Models\Status;
use App\Validation;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

class ProjectsController extends BaseController
{
    public function list(): void
    {
        $projects = $this->entityManager
            ->getRepository(Project::class)
            ->findAll();
        $this->view->renderContent('list', compact('projects'));

    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function read(): void
    {

        $id = $this->request->getRouteParam('id');

        $project = $this->entityManager->find(Project::class, $id);
        $this->view->renderContent('read', compact('project'));
    }

    /**
     * @throws ORMException
     */
    public function create()
    {
        $statuses = $this->entityManager->getRepository(Status::class)->findAll();
        $owners = $this->entityManager->getRepository(Owner::class)->findAll();
        if ($this->request->isPost()) {
            $body = $this->request->getBody();
            $validation = new Validation();
            $rules = [
                'title' => [Validation::RULE_REQUIRED],
                'description' => [Validation::RULE_REQUIRED],
            ];
            if (!isset($body['owner'])) {
                $rules['owner-name'] = [Validation::RULE_REQUIRED];
                $rules['owner-email'] = [
                    Validation::RULE_REQUIRED,
                    [
                        Validation::RULE_UNIQUE,
                        'class' => Owner::class,
                        'attribute' => 'email'
                    ]
                ];
            }
            if ($validation->validate($rules, $body)) {
                $project = (new Project())
                    ->setTitle($body['title'])
                    ->setDescription($body['description'])
                    ->setStatus($this->entityManager->find(Status::class, $body['status']));

                if (isset($body['owner'])) {
                    $project->setOwner($this->entityManager->find(Owner::class, $body['owner']));
                } else {
                    $owner = (new Owner())
                        ->setName($body['owner-name'])
                        ->setEmail($body['owner-email']);
                    $project->setOwner($owner);
                }

                $this->entityManager->persist($project);
                $this->entityManager->flush();
                $this->response->redirect('/project/' . $project->getId());
            }
            $view = $this->view->fetchResponse('form', [
                'errors' => $validation->getErrors(),
                'statuses' => $statuses,
                'owners' => $owners,
                'old' => $body
            ]);
            return $this->response->json([
                'validation' => false,
                'view' => $view,
            ]);
        }
        $this->view->renderContent('form', compact('statuses', 'owners'));
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function edit(): void
    {
        $statuses = $this->entityManager->getRepository(Status::class)->findAll();
        $owners = $this->entityManager->getRepository(Owner::class)->findAll();
        $project = $this->entityManager->find(Project::class, $this->request->getRouteParam('id'));
        if ($this->request->isPost()) {
            $body = $this->request->getBody();
            $validation = new Validation();
            if ($validation->validate([
                'title' => [Validation::RULE_REQUIRED],
                'description' => [Validation::RULE_REQUIRED]
            ], $body)) {
                $project
                    ->setTitle($body['title'])
                    ->setDescription($body['description'])
                    ->setStatus($this->entityManager->find(Status::class, $body['status']))
                    ->setOwner($this->entityManager->find(Owner::class, $body['owner']));
                $this->entityManager->flush();
                $this->response->redirect('/project/' . $project->getId());
            }
            $this->view->renderContent('form', [
                'errors' => $validation->getErrors(),
                'statuses' => $statuses,
                'owners' => $owners
            ]);
        }
        $this->view->renderContent('form', compact('project', 'statuses', 'owners'));
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function delete(): void
    {
        $project = $this->entityManager->find(Project::class, $this->request->getRouteParam('id'));
        $this->entityManager->remove($project);
        $this->entityManager->flush();
        $projects = $this->entityManager->getRepository(Project::class)->findAll();
        echo $this->view->fetchResponse('list', compact('projects'));

    }

}