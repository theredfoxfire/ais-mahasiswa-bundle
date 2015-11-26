<?php

namespace Ais\MahasiswaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Request\ParamFetcherInterface;

use Symfony\Component\Form\FormTypeInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Ais\MahasiswaBundle\Exception\InvalidFormException;
use Ais\MahasiswaBundle\Form\MahasiswaType;
use Ais\MahasiswaBundle\Model\MahasiswaInterface;


class MahasiswaController extends FOSRestController
{
    /**
     * List all mahasiswas.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Annotations\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing mahasiswas.")
     * @Annotations\QueryParam(name="limit", requirements="\d+", default="5", description="How many mahasiswas to return.")
     *
     * @Annotations\View(
     *  templateVar="mahasiswas"
     * )
     *
     * @param Request               $request      the request object
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function getMahasiswasAction(Request $request, ParamFetcherInterface $paramFetcher)
    {
        $offset = $paramFetcher->get('offset');
        $offset = null == $offset ? 0 : $offset;
        $limit = $paramFetcher->get('limit');

        return $this->container->get('ais_mahasiswa.mahasiswa.handler')->all($limit, $offset);
    }

    /**
     * Get single Mahasiswa.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Gets a Mahasiswa for a given id",
     *   output = "Ais\MahasiswaBundle\Entity\Mahasiswa",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the mahasiswa is not found"
     *   }
     * )
     *
     * @Annotations\View(templateVar="mahasiswa")
     *
     * @param int     $id      the mahasiswa id
     *
     * @return array
     *
     * @throws NotFoundHttpException when mahasiswa not exist
     */
    public function getMahasiswaAction($id)
    {
        $mahasiswa = $this->getOr404($id);

        return $mahasiswa;
    }

    /**
     * Presents the form to use to create a new mahasiswa.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Annotations\View(
     *  templateVar = "form"
     * )
     *
     * @return FormTypeInterface
     */
    public function newMahasiswaAction()
    {
        return $this->createForm(new MahasiswaType());
    }
    
    /**
     * Presents the form to use to edit mahasiswa.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Annotations\View(
     *  template = "AisMahasiswaBundle:Mahasiswa:editMahasiswa.html.twig",
     *  templateVar = "form"
     * )
     *
     * @param Request $request the request object
     * @param int     $id      the mahasiswa id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when mahasiswa not exist
     */
    public function editMahasiswaAction($id)
    {
		$mahasiswa = $this->getMahasiswaAction($id);
		
        return array('form' => $this->createForm(new MahasiswaType(), $mahasiswa), 'mahasiswa' => $mahasiswa);
    }

    /**
     * Create a Mahasiswa from the submitted data.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Creates a new mahasiswa from the submitted data.",
     *   input = "Ais\MahasiswaBundle\Form\MahasiswaType",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @Annotations\View(
     *  template = "AisMahasiswaBundle:Mahasiswa:newMahasiswa.html.twig",
     *  statusCode = Codes::HTTP_BAD_REQUEST,
     *  templateVar = "form"
     * )
     *
     * @param Request $request the request object
     *
     * @return FormTypeInterface|View
     */
    public function postMahasiswaAction(Request $request)
    {
        try {
            $newMahasiswa = $this->container->get('ais_mahasiswa.mahasiswa.handler')->post(
                $request->request->all()
            );

            $routeOptions = array(
                'id' => $newMahasiswa->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('api_1_get_mahasiswa', $routeOptions, Codes::HTTP_CREATED);

        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
    }

    /**
     * Update existing mahasiswa from the submitted data or create a new mahasiswa at a specific location.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "Ais\MahasiswaBundle\Form\MahasiswaType",
     *   statusCodes = {
     *     201 = "Returned when the Mahasiswa is created",
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @Annotations\View(
     *  template = "AisMahasiswaBundle:Mahasiswa:editMahasiswa.html.twig",
     *  templateVar = "form"
     * )
     *
     * @param Request $request the request object
     * @param int     $id      the mahasiswa id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when mahasiswa not exist
     */
    public function putMahasiswaAction(Request $request, $id)
    {
        try {
            if (!($mahasiswa = $this->container->get('ais_mahasiswa.mahasiswa.handler')->get($id))) {
                $statusCode = Codes::HTTP_CREATED;
                $mahasiswa = $this->container->get('ais_mahasiswa.mahasiswa.handler')->post(
                    $request->request->all()
                );
            } else {
                $statusCode = Codes::HTTP_NO_CONTENT;
                $mahasiswa = $this->container->get('ais_mahasiswa.mahasiswa.handler')->put(
                    $mahasiswa,
                    $request->request->all()
                );
            }

            $routeOptions = array(
                'id' => $mahasiswa->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('api_1_get_mahasiswa', $routeOptions, $statusCode);

        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
    }

    /**
     * Update existing mahasiswa from the submitted data or create a new mahasiswa at a specific location.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "Ais\MahasiswaBundle\Form\MahasiswaType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @Annotations\View(
     *  template = "AisMahasiswaBundle:Mahasiswa:editMahasiswa.html.twig",
     *  templateVar = "form"
     * )
     *
     * @param Request $request the request object
     * @param int     $id      the mahasiswa id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when mahasiswa not exist
     */
    public function patchMahasiswaAction(Request $request, $id)
    {
        try {
            $mahasiswa = $this->container->get('ais_mahasiswa.mahasiswa.handler')->patch(
                $this->getOr404($id),
                $request->request->all()
            );

            $routeOptions = array(
                'id' => $mahasiswa->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('api_1_get_mahasiswa', $routeOptions, Codes::HTTP_NO_CONTENT);

        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
    }

    /**
     * Fetch a Mahasiswa or throw an 404 Exception.
     *
     * @param mixed $id
     *
     * @return MahasiswaInterface
     *
     * @throws NotFoundHttpException
     */
    protected function getOr404($id)
    {
        if (!($mahasiswa = $this->container->get('ais_mahasiswa.mahasiswa.handler')->get($id))) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.',$id));
        }

        return $mahasiswa;
    }
    
    public function postUpdateMahasiswaAction(Request $request, $id)
    {
		try {
            $mahasiswa = $this->container->get('ais_mahasiswa.mahasiswa.handler')->patch(
                $this->getOr404($id),
                $request->request->all()
            );

            $routeOptions = array(
                'id' => $mahasiswa->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('api_1_get_mahasiswa', $routeOptions, Codes::HTTP_NO_CONTENT);

        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
	}
}
