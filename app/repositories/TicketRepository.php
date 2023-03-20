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
    // Get a ticket by ID, returns a ticket
    public function getTicketByID($ticketID): HistoryTicket
    {
        try {
            $query = "select u.firstName , u.lastName as surname , u.email , t.qr_code, e.name as EventName ,
            e.startTime , e.endTime , e.price * t.quantity as Price, g.name , g.lastName , g.`language`
                        FROM Tickets t
                        INNER JOIN Events e ON t.eventId = e.eventId
                        LEFT JOIN StrollHistoryTicket sht ON t.ticketId = sht.ticketId
                        LEFT JOIN Guides g ON sht.guideId = g.guideId
                        LEFT JOIN Customers c ON t.userId = c.userId
                        LEFT JOIN Users u ON c.userId = u.userId
                        LEFT JOIN Addresses a ON c.addressId = a.addressId
                        WHERE t.ticketId = :ticketID";

            $stmt = $this->connection->prepare($query);
            $stmt->bindValue(":ticketID", $ticketID);
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
            $event->setPrice($result['Price']);
            $ticket->setEvent($event);

            $guide = new Guide();
            $guide->setFirstName($result['name']);
            $guide->setLastName($result['lastName']);
            $guide->setLanguage($result['language']);
            $ticket->setGuide($guide);

            $customer = new Customer();
            $customer->setFirstName($result['firstName']);
            $customer->setLastName($result['surname']);
            $customer->setEmail($result['email']);
            $ticket->setCustomer($customer);

            return $ticket;

        } catch (Exception $ex) {
            throw ($ex);
        }
    }

}