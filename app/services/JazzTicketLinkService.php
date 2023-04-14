<?php

require_once("TicketLinkService.php");
require_once(__DIR__ . "/../repositories/JazzTicketLinkRepository.php");

class JazzTicketLinkService extends TicketLinkService
{
    public function __construct()
    {
        $this->repo = new JazzTicketLinkRepository();
    }
}
