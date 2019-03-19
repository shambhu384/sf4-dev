<?php

declare(strict_types=1);


namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use App\Entity\Meeting;
use App\Entity\User;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use FOS\RestBundle\Controller\Annotations\Version;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;
use App\Repository\UserRepository;


/**
 * Meeting Controller
 *
 * @Route("/meetings")
 * @Version("v1")
 */

class MeetingRegistrationController extends AbstractController
{
    /**
     * Register
     * @FOSRest\Post("/registration")
     * @SWG\Response(
     *     response=200,
     *     description="Returns the Meetings of an user",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=Meeting::class, groups={"full"}))
     *     )
     * )
     * @SWG\Parameter(
     *     name="order",
     *     in="query",
     *     type="string",
     *     description="The field used to order Meetings"
     * )
     * @SWG\Tag(name="Meetings")
     *
     * @return View
     */
    public function registerUserMeeting(Request $request, UserRepository $userRepository): View
    {
        $em = $this->getDoctrine()->getManager();
        // Check user already exists
        $user = $userRepository->findBy(array('id' => $request->get('user_id')));
        if (!$user) {
            throw new HttpException(400, 'Userid invalid.');
        }

        $meeting = $em->getRepository(Meeting::class)->find(array('id' => $request->get('meeting_id')));
        if (!$meeting) {
            throw new HttpException(400, 'Meetingid invalid.');
        }

        $user->setMeeting($meeting);
        $meeting->setUser($user);

        $em->persist($user);
        $em->persist($meeting);
        $em->flush();
        return View::create('', Response::HTTP_NO_CONTENT, []);
    }

    /**
     * Register
     * @FOSRest\DELETE("/unregistration")
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns the Meetings of an user",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=Meeting::class, groups={"full"}))
     *     )
     * )
     * @SWG\Parameter(
     *     name="order",
     *     in="query",
     *     type="string",
     *     description="The field used to order Meetings"
     * )
     * @SWG\Tag(name="Meetings")
     * @return View
     */
    public function unregisterUserMeeting(Request $request, UserRepository $userRepository): View
    {
        $em = $this->getDoctrine()->getManager();
        // Check user already exists
        $user = $userManager->findUserBy(array('id' => $request->get('user_id')));
        if (!$user) {
            throw new HttpException(400, 'Userid invalid.');
        }

        $meeting = $em->getRepository(Meeting::class)->find(array('id' => $request->get('meeting_id')));
        if (!$meeting) {
            throw new HttpException(400, 'Meetingid invalid.');
        }

        $user->removeMeeting($meeting);
        //$meeting->removeUser($user);
        $em->remove($meeting);
        //$em->remove($user);
        $em->flush();
        return View::create('', Response::HTTP_NO_CONTENT, []);
    }
}
