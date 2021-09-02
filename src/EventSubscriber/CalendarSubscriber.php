<?php

namespace App\EventSubscriber;

use App\Repository\BookingRepository;
use CalendarBundle\CalendarEvents;
use CalendarBundle\Entity\Event;
use CalendarBundle\Event\CalendarEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Security;

class CalendarSubscriber implements EventSubscriberInterface
{
    private $bookingRepository;
    private $router;
    private $security;

    public function __construct(
        BookingRepository $bookingRepository,
        UrlGeneratorInterface $router,
        Security $security
    ) {
        $this->bookingRepository = $bookingRepository;
        $this->router = $router;
        $this->security = $security;
    }

    public static function getSubscribedEvents()
    {
        return [
            CalendarEvents::SET_DATA => 'onCalendarSetData',
        ];
    }

    public function onCalendarSetData(CalendarEvent $calendar)
    {
        $start = $calendar->getStart();
        $end = $calendar->getEnd();
        $filters = $calendar->getFilters();
        $userId = $this->security->getUser()->getId();

        switch($filters['calendar-id']) {
            case 'famille-calendar':
                $this->fillCalendarFamille($calendar, $start, $end, $filters, $userId);
                break;
            case 'edu-calendar':
                $this->fillCalendarEdu($calendar, $start, $end, $filters);
                break;
        }


    }

    public function fillCalendarFamille(CalendarEvent $calendar, \DateTimeInterface $start, \DateTimeInterface $end, array $filters, $userId){
        // Modify the query to fit to your entity and needs
        // Change booking.beginAt by your start date property
        $bookings = $this->bookingRepository
            ->createQueryBuilder('booking')
            ->where('booking.beginAt BETWEEN :start and :end OR booking.endAt BETWEEN :start and :end')
            ->andWhere('booking.famille = :id' )
            ->setParameter('id', $userId)
            ->setParameter('start', $start->format('Y-m-d H:i:s'))
            ->setParameter('end', $end->format('Y-m-d H:i:s'))
            ->getQuery()
            ->getResult()
        ;

        foreach ($bookings as $booking) {
            // this create the events with your data (here booking data) to fill calendar
            $bookingEvent = new Event(
                $booking->getTitle(),
                $booking->getBeginAt(),
                $booking->getEndAt() // If the end date is null or not defined, a all day event is created.
            );

            /*
             * Add custom options to events
             *
             * For more information see: https://fullcalendar.io/docs/event-object
             * and: https://github.com/fullcalendar/fullcalendar/blob/master/src/core/options.ts
             */

            /*$bookingEvent->setOptions([
                                          'backgroundColor' => '#5EB6DE',
                                          'borderColor' => '#5EB6DE',
                                      ]);*/
            $bookingEvent->addOption(
                'url',
                $this->router->generate('booking_show', [
                    'id' => $booking->getId(),
                ])
            );

            // finally, add the event to the CalendarEvent to fill the calendar
            $calendar->addEvent($bookingEvent);
        }
    }

    public function fillCalendarEdu(CalendarEvent $calendar, \DateTimeInterface $start, \DateTimeInterface $end, array $filters)
    {
        //TODO: Ajouter id de l'utilisateur visé par la page.
        $bookings = $this->bookingRepository
            ->createQueryBuilder('booking')
            ->where('booking.beginAt BETWEEN :start and :end OR booking.endAt BETWEEN :start and :end')
            ->setParameter('start', $start->format('Y-m-d H:i:s'))
            ->setParameter('end', $end->format('Y-m-d H:i:s'))
            ->getQuery()
            ->getResult()
        ;

        foreach ($bookings as $booking) {

            $bookingEvent = new Event(
                $booking->getFamille()->getLastname(),
                $booking->getBeginAt(),
                $booking->getEndAt()
            );


            $bookingEvent->setOptions([
                                          'backgroundColor' => 'darkblue',
                                          'borderColor' => 'darkblue',
                                      ]);
            $bookingEvent->addOption(
                'url',
                $this->router->generate('booking_show', [
                    'id' => $booking->getId(),
                ])
            );

            $calendar->addEvent($bookingEvent);
        }
    }
}