<?php

require_once("TicketLinkService.php");
require_once(__DIR__ . "/../repositories/JazzTicketLinkRepository.php");

/**
 * @author Konrad
 */
class JazzTicketLinkService extends TicketLinkService
{
    public function __construct()
    {
        parent::__construct();
        $this->repo = new JazzTicketLinkRepository();
    }
}
