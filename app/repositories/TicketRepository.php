<?php
require_once(__DIR__ . '/../models/Ticket/Ticket.php');
require_once(__DIR__ . '/../models/Ticket/HistoryTicket.php');
require_once(__DIR__ . '/../models/Event.php');
require_once(__DIR__ . '/../models/Address.php');
require_once(__DIR__ . '/../models/Customer.php');
require_once(__DIR__ . '/../models/User.php');
require_once(__DIR__ . '/../models/Guide.php');
require_once(__DIR__ . '/../models/Order.php');

require_once(__DIR__ . '/../repositories/Repository.php');
require_once(__DIR__ . '/../models/Exceptions/TicketNotFoundException.php');

require_once(__DIR__ . '/../repositories/EventRepository.php');
require_once(__DIR__ . '/../repositories/UserRepository.php');


class TicketRepository extends Repository
{
    //Get all tickets by orderId
    public function getAllHistoryTicketsByOrderId(Order $order): array
    {
        try{
            $sql = "select t.ticketId, t.qr_code, t.eventId, t.isScanned, t.basePrice, t.vat, sum(t2.ticketTypePrice) as Price, c.userId, g.name , g.lastName , g.`language`
            from tickets t
            join orders o on o.orderId = t.orderId  
            join events e on t.eventId = e.eventId
            join historyevents h on e.eventId = h.eventId 
            join guides g on h.guideId = g.guideId 
            join customers c on o.customerId  = c.userId
            join users u on u.userId = c.userId
            join addresses a on a.addressId = c.userId
            JOIN tickettypes t2 ON t.ticketTypeId = t2.ticketTypeId 
            where t.orderId = :orderId
            GROUP BY t.ticketId, t.qr_code, g.name, g.lastName, g.`language`";

            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue(":orderId", $order->getOrderId());
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (is_bool($result)) {
                throw new TicketNotFoundException("Ticket ID not found");
            }

            $tickets = array();

            foreach ($result as $row) {
                $ticket = new HistoryTicket();
                $ticket->setTicketId($row['ticketId']);
                $ticket->setQrCodeData($row['qr_code']);
                $ticket->setFullPrice($row['Price']);

                $userRep = new UserRepository();
                $user = $userRep->getById($row['userId']);
                $customer = new Customer();
                $customer->setFirstName($user->getFirstName());
                $customer->setLastName($user->getLastName());
                $customer->setEmail($user->getEmail());
                $order->setCustomer($customer);

                $eventRep = new EventRepository();
                $event = $eventRep->getEventById($row['eventId']);
                $ticket->setEvent($event);

                $guide = new Guide();
                $guide->setFirstName($row['name']);
                $guide->setLastName($row['lastName']);
                $guide->setLanguage($row['language']);
                $ticket->setGuide($guide);

                array_push($tickets, $ticket);                
            }
            return $tickets;
        }catch(Exception $ex){
            throw($ex);
        }
    }

    public function addTicketToOrder($orderId, $ticket)
    {

    }

    public function removeTicketFromOrder($orderId, $ticket)
    {

    }

}