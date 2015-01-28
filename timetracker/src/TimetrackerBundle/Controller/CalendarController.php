<?php

namespace TimetrackerBundle\Controller;

use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TimetrackerBundle\Entity\Employee;
use TimetrackerBundle\Entity\Note;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class CalendarController extends Controller
{
	/**
	 * Show Calendar
	 */
    public function showAction(Employee $employee, $year, $month, $day)
    {
        $calendar = $this->get('calendar');
        $calendar->personalize($employee);

    	return $this->render('TimetrackerBundle:Calendar:show.html.twig', compact('calendar', 'employee'));
    }

    /**
     * Store the Note / AJAX
     */
    public function storeNoteAction($id, $year, $month, $day, Request $request)
    {
        $date = new Datetime("{$year}-{$month}-{$day}");
        $property = $request->request->get('name');
        $value = $request->request->get('value');

        $em = $this->getDoctrine()->getManager();

        $employee = $em->getRepository('TimetrackerBundle:Employee')->find($request->get('id'));
        $note = $em->getRepository('TimetrackerBundle:Note')->findOneBy(['date' => $date, 'employee' => $employee]);

        if( ! $note)
        {
            $note = new Note;
            $note->setDate($date);
        }

        $note->{'set' . $property}($value);
        $note->setEmployee($employee);

        $em->persist($note);
        $em->flush();

        return new JsonResponse(['success' => true]);
    }
}
