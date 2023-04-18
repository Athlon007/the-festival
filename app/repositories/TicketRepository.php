<?php
require_once(__DIR__ . '/../models/Ticket/Ticket.php');
require_once(__DIR__ . '/../models/Ticket/HistoryTicket.php');
require_once(__DIR__ . '/../models/Event.php');
require_once(__DIR__ . '/../models/Address.php');
require_once(__DIR__ . '/../models/Customer.php');
require_once(__DIR__ . '/../models/User.php');
require_once(__DIR__ . '/../models/Guide.php');

require_once(__DIR__ . '/../repositories/Repository.php');
require_once(__DIR__ . '/../models/Exceptions/TicketNotFoundException.php');


class TicketRepository extends Repository
{
    public function getTicketByID($orderId): HistoryTicket
    {
        try {
            $query = "select u.firstName , u.lastName as surname, u.email, t.qr_code, e.name  as EventName,
            e.startTime , e.endTime , g.name , g.lastName , g.`language` 
            from tickets t
            join orders o on o.orderId = t.orderId  
            join events e on t.eventId = e.eventId
            join historyevents h on e.eventId = h.eventId 
            join guides g on h.guideId = g.guideId 
            join customers c on o.customerId  = c.userId
            join users u on u.userId = c.userId
            join addresses a on a.addressId = c.userId
            where t.orderId = :orderId";

            $stmt = $this->connection->prepare($query);
            $stmt->bindValue(":ticketID", $orderId);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if (is_bool($result)) {
                throw new TicketNotFoundException("Ticket ID not found");
            }

            $ticket = new HistoryTicket();
            $ticket->setQrCodeData($result['qr_code']);

            $event = new Event();
            $event->setName($result['EventName']);
            $event->setStartTime(new DateTime($result['startTime']));
            $event->setEndTime(new DateTime($result['endTime']));
            $ticket->setEvent($event);

            $guide = new Guide();
            $guide->setFirstName($result['name']);
            $guide->setLastName($result['lastName']);
            $guide->setLanguage($result['language']);
            $ticket->setGuide($guide);

            return $ticket;

        } catch (Exception $ex) {
            throw ($ex);
        }
    }

    // Get all tickets by orderId
    public function getAllHistoryTicketsByOrderId($orderId) : array
    {
        try{
            $query = "select u.firstName , u.lastName as surname, u.email, t.qr_code, e.name  as EventName,
            e.startTime , e.endTime , g.name , g.lastName , g.`language` 
            from tickets t
            join orders o on o.orderId = t.orderId  
            join events e on t.eventId = e.eventId
            join historyevents h on e.eventId = h.eventId 
            join guides g on h.guideId = g.guideId 
            join customers c on o.customerId  = c.userId
            join users u on u.userId = c.userId
            join addresses a on a.addressId = c.userId
            where t.orderId = :orderId";

            $stmt = $this->connection->prepare($query);
            $stmt->bindValue(":orderId", $orderId);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (is_bool($result)) {
                throw new TicketNotFoundException("Ticket ID not found");
            }

            $tickets = array();
            foreach ($result as $row) {
                $ticket = new HistoryTicket();
                $ticket->setQrCodeData($row['qr_code']);

                $event = new Event();
                $event->setName($row['EventName']);
                $event->setStartTime(new DateTime($row['startTime']));
                $event->setEndTime(new DateTime($row['endTime']));
                $ticket->setEvent($event);

                $guide = new Guide();
                $guide->setFirstName($row['name']);
                $guide->setLastName($row['lastName']);
                $guide->setLanguage($row['language']);
                $ticket->setGuide($guide);

                array_push($tickets, $ticket);
            }

            return $tickets;

        } catch (Exception $ex) {
            throw ($ex);
        }
    }

    public function addTicketToOrder($orderId, $ticket)
    {

    }

    public function removeTicketFromOrder($orderId, $ticket)
    {

    }

}