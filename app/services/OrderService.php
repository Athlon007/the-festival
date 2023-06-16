<?php

//Repositories
require_once(__DIR__ . '/../repositories/OrderRepository.php');
require_once(__DIR__ . '/../repositories/TicketLinkRepository.php');
require_once(__DIR__ . '/../repositories/TicketRepository.php');
require_once(__DIR__ . '/../repositories/CustomerRepository.php');

//Services
require_once(__DIR__ . '/../services/TicketService.php');
require_once(__DIR__ . '/../services/PDFService.php');

//Models
require_once(__DIR__ . '/../models/Order.php');
require_once(__DIR__ . '/../models/Ticket/Ticket.php');
require_once(__DIR__ . '/../models/Exceptions/OrderNotFoundException.php');

class OrderService
{
    private $orderRepository;
    private $customerRepository;
    //private $invoiceService;
    //private $ticketController;

    public function __construct()
    {
        $this->orderRepository = new OrderRepository();
        $this->customerRepository = new CustomerRepository();
        //$this->invoiceService = new InvoiceService();
        //$this->ticketController = new TicketController();
    }

    public function getOrderById(int $id): Order
    {
        //Get the order object
        $order = $this->orderRepository->getOrderById($id);
        //Get the customer object attached in order
        // Btw, customer may be null if the order is made by a visitor
        if ($order->getCustomer() != null) {
            $order->setCustomer($this->customerRepository->getById($order->getCustomer()->getUserId()));
        } else {
            $order->setCustomer(null);
        }
        return $order;
    }

    public function getOrderHistory(int $customerId): array
    {
        $orders = $this->orderRepository->getOrderHistory($customerId);
        foreach ($orders as $order) {
            $order->setCustomer($this->customerRepository->getById($order->getCustomer()->getUserId()));
        }
        return $orders;
    }

    public function getOrdersToExport($isPaid = null, $customerId = null)
    {
        return $this->orderRepository->getOrdersToExport($isPaid, $customerId);
    }

    public function downloadOrders()
    {
        $orders = $this->getOrdersToExport(true);

        if ($orders == null) {
            echo "No orders found";
            exit;
        }

        $fileName = "orders-data_" . date('Y-m-d') . ".xls";
        $fields = array('ID', 'ORDER DATE', 'CUSTOMER NAME', 'CUSTOMER EMAIL', 'EVENT NAME', 'BASE PRICE', 'PRICE', 'QUANTITY', 'TOTAL BASE PRICE', 'TOTAL PRICE');
        $excelData = implode("\t", $fields) . "\n";

        foreach ($orders as $order) {
            foreach ($order->getOrderItems() as $orderItem) {
                $lineData = array(
                    $order->getOrderId(),
                    date_format($order->getOrderDate(), 'd/m/Y'),
                    $order->getCustomer()->getFirstName() . " " . $order->getCustomer()->getLastName(),
                    $order->getCustomer()->getEmail(),
                    $orderItem->getEventName(),
                    number_format($orderItem->getBasePrice(), 2),
                    number_format($orderItem->getFullTicketPrice(), 2),
                    $orderItem->getQuantity(),
                    number_format($orderItem->getTotalBasePrice(), 2),
                    number_format($orderItem->getTotalFullPrice(), 2)
                );
                array_walk($lineData, array($this, 'filterData'));
                $excelData .= implode("\t", $lineData) . "\n";
            }
        }

        // Send HTTP headers
        header("Content-type: application/vnd.ms-excel; charset=utf-8");
        header("Content-Disposition: attachment; filename=\"$fileName\"");
        header("Cache-Control: max-age=0");

        // Output the Excel data to the output buffer and exit
        echo $excelData;
        exit;
    }

    private function filterData(&$str)
    {
        $str = preg_replace("/\t/", "\\t", $str);
        $str = preg_replace("/\r?\n/", "\\n", $str);
        if (strstr($str, '"'))
            $str = '"' . str_replace('"', '""', $str) . '"';
    }

    public function getCartOrderForCustomer($customerId)
    {
        return $this->orderRepository->getCartOrderForCustomer($customerId);
    }

    public function createOrder(int $ticketLinkId, int $customerId = NULL): Order
    {
        $order = new Order();
        $order->setOrderDate(new DateTime());
        $order->setIsPaid(false);

        if (isset($customerId))
            $order->setCustomer($this->customerRepository->getById($customerId));

        $order = $this->orderRepository->insertOrder($order);

        //After we created the order, we can create the first orderItem that will be linked to the new order.
        $this->createOrderItem($ticketLinkId, $order->getOrderId());
        return $order;
    }

    public function createOrderItem(int $ticketLinkId, int $orderId): OrderItem
    {
        $orderItem = new OrderItem();
        $orderItem->setTicketLinkId($ticketLinkId);
        $orderItem->setQuantity(1);

        return $this->orderRepository->insertOrderItem($orderItem, $orderId);
    }

    public function updateOrder($orderId, $order): Order
    {
        return $this->orderRepository->updateOrder($orderId, $order);
    }

    public function updateOrderItem($orderItemId, $orderItem): OrderItem
    {
        return $this->orderRepository->updateOrderItem($orderItemId, $orderItem);
    }

    public function deleteOrder($orderId): void
    {
        $this->orderRepository->deleteOrder($orderId);
    }

    public function deleteOrderItem($orderItemId): void
    {
        $this->orderRepository->deleteOrderItem($orderItemId);
    }

    //If the customer has an unpaid order and logs in while having created another order as a visitor, merge the two orders.
    public function mergeOrders($customerOrder, $sessionOrder): Order
    {

        //Nested loop that checks if there are orderitems that represent the same ticket
        foreach ($customerOrder->getOrderItems() as $customerOrderItem) {
            foreach ($sessionOrder->getOrderItems() as $sessionOrderItem) {
                //If there is a match in ticketlink then add the quantity of the sessionOrderItem to the customerOrderItem and update
                if ($sessionOrderItem->getTicketLinkId() == $customerOrderItem->getTicketLinkId()) {
                    $customerOrderItem->setQuantity($customerOrderItem->getQuantity() + $sessionOrderItem->getQuantity());
                    $this->updateOrderItem($customerOrderItem->getOrderItemId(), $customerOrderItem);
                }
                //If the orderItem is unique then we add it to the customerOrder and update it
                else {
                    $sessionOrderItem->setOrderId($customerOrder->getOrderId());
                    $customerOrder->addOrderItem($this->updateOrderItem($customerOrderItem->getOrderItemId(), $customerOrderItem));
                }
            }
        }

        //Delete the sessionOrder from db
        $this->deleteOrder($sessionOrder->getOrderId());

        return $customerOrder;
    }

    //TODO: Check if redundant
    public function getAllOrders($limit = null, $offset = null, $isPaid = null)
    {
        return $this->orderRepository->getAllOrders($limit, $offset, $isPaid);
    }

//    /**
//     * @param Order $order
//     * @return void
//     * @throws Exception
//     */
//    public function sendTicketsAndInvoice(Order $order): void
//    {
//        //Send invoice via email
//        $this->invoiceService->sendInvoiceEmail($order);
//
//        // Get all tickets and send them to the user
//        $this->ticketController->getAllTickets($order);
//    }
}
