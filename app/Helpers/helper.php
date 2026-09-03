<?php

function whatsappLink($phone,$message)
{
    return 'https://wa.me/'.$phone.'?text='.urlencode($message);
}
